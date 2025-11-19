<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::where('type', 'berita')
            ->when($search, function ($query, $search) {
                $lowerSearch = strtolower($search);
                $query->whereRaw('LOWER(judul) LIKE ?', ["%{$lowerSearch}%"]);
            })
            ->orderBy('created_date', 'desc')
            ->paginate(8)
            ->withQueryString();

        return inertia('admin/berita/Index', [
            'articles' => $articles,
            'searchQuery' => $search,
        ]);
    }

    public function storeBerita(Request $request)
    {
           // Validasi input
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['nullable', Rule::in(['berita', 'pengumuman'])],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'date' => ['required', 'date'],
            'thumbnail' => ['required', 'image', 'max:2048'], // 2MB max
            'attachment' => ['nullable', 'file', 'max:5120'], // 5MB max
        ]);

        // Simpan thumbnail ke storage
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('articles/thumbnails', 'public');
        }

        // Simpan lampiran jika ada
        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment')) {
            $attachmentFile = $request->file('attachment');
            $attachmentName = $attachmentFile->getClientOriginalName();
            $attachmentPath = $attachmentFile->store('articles/attachments', 'public');
        }

        // Buat artikel baru
        $article = new Article([
            'url_thumbnail' => $thumbnailPath ? Storage::url($thumbnailPath) : null,
            'url_attachment' => $attachmentPath ? Storage::url($attachmentPath) : null,
            'attachment_name' => $attachmentName,
            'judul' => $validated['judul'],
            'content' => $validated['content'],
            'type' => 'berita',
            'status' => $validated['status'],
        ]);

        // Karena kita punya UUID primary key, generate manual jika belum ada
        $article->article_id = Str::uuid()->toString();
        $article->created_date = now(); // gunakan tanggal publikasi dari form
        $article->save();
        // Response
        return redirect()
            ->to('/admin/berita')
            ->with('success', 'Artikel berhasil dibuat.');
    }
    public function editBerita($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();
        // dd($article);
        return inertia('admin/berita/Edit', [
            'article' => $article,
        ]);
    }

public function updateBerita(Request $request, $id)
{
    $article = Article::where('article_id', $id)->firstOrFail();

    $validated = $request->validate([
        'judul' => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
        'status' => ['required', Rule::in(['published', 'draft'])],
        'date' => ['required', 'date'],
        'thumbnail' => ['nullable', 'image', 'max:2048'],
        'attachment' => ['nullable', 'file', 'max:5120'],
    ]);

    if ($request->hasFile('thumbnail')) {
        if ($article->url_thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_thumbnail));
        }
        $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        $article->url_thumbnail = Storage::url($thumbnailPath);
    }

    if ($request->hasFile('attachment')) {
        if ($article->url_attachment) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_attachment));
        }
        $attachmentFile = $request->file('attachment');
        $attachmentName = $attachmentFile->getClientOriginalName();
        $attachmentPath = $attachmentFile->store('articles/attachments', 'public');
        $article->url_attachment = Storage::url($attachmentPath);
        $article->attachment_name = $attachmentName;
    }

    $article->update([
        'judul' => $validated['judul'],
        'content' => $validated['content'],
        'status' => $validated['status'],
        'updated_date' => now(),
    ]);

    return redirect()
        ->to('/admin/berita')
        ->with('success', 'Berita berhasil diperbarui.');
}
   public function destroyBerita($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        // Hapus thumbnail dari storage jika ada
        if ($article->url_thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_thumbnail));
        }

        // Hapus lampiran dari storage jika ada
        if ($article->url_attachment) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_attachment));
        }

        $article->delete();

        return redirect()
            ->to('/admin/berita')
            ->with('success', 'Berita berhasil dihapus.');
    }


    public function showBerita($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        return inertia('admin/berita/Detail', [
            'article' => $article,
        ]);
    }

    public function beritaUser(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::where('type', 'berita')
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                $lowerSearch = strtolower($search);
                $query->whereRaw('LOWER(judul) LIKE ?', ["%{$lowerSearch}%"]);
            })
            ->orderBy('created_date', 'desc')
            ->paginate(6)
            ->withQueryString();

        return inertia('user/Berita', [
            'articles' => $articles,
            'searchQuery' => $search,
        ]);
    }
    public function pengumumanUser(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::where('type', 'pengumuman')
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                $lowerSearch = strtolower($search);
                $query->whereRaw('LOWER(judul) LIKE ?', ["%{$lowerSearch}%"]);
            })
            ->orderBy('created_date', 'desc')
            ->paginate(3)
            ->withQueryString();

        return inertia('user/Pengumuman', [
            'articles' => $articles,
            'searchQuery' => $search,
        ]);
    }


    public function indexPengumuman(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::where('type', 'pengumuman')
            ->when($search, function ($query, $search) {
                $lowerSearch = strtolower($search);
                $query->whereRaw('LOWER(judul) LIKE ?', ["%{$lowerSearch}%"]);
            })
            ->orderBy('created_date', 'desc')
            ->paginate(8)
            ->withQueryString();

        return inertia('admin/pengumuman/Index', [
            'articles' => $articles,
            'searchQuery' => $search,
        ]);
    }

    public function storePengumuman(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'date' => ['required', 'date'],
            'thumbnail' => ['required', 'image', 'max:2048'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment')) {
            $attachmentName = $request->file('attachment')->getClientOriginalName();
            $attachmentPath = $request->file('attachment')->storeAs('articles/attachments', $attachmentName, 'public');
        }

        $article = new Article([
            'url_thumbnail' => $thumbnailPath ? Storage::url($thumbnailPath) : null,
            'url_attachment' => $attachmentPath ? Storage::url($attachmentPath) : null,
            'attachment_name' => $attachmentName,
            'judul' => $validated['judul'],
            'content' => $validated['content'],
            'type' => 'pengumuman',
            'status' => $validated['status'],
        ]);

        $article->article_id = Str::uuid()->toString();
        $article->created_date = now();
        $article->save();

        return redirect()
            ->to('/admin/pengumuman')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function editPengumuman($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();
        return inertia('admin/pengumuman/Edit', [
            'article' => $article,
        ]);
    }

    public function updatePengumuman(Request $request, $id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'date' => ['required', 'date'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($article->url_thumbnail) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_thumbnail));
            }
            $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
            $article->url_thumbnail = Storage::url($thumbnailPath);
        }

        if ($request->hasFile('attachment')) {
            if ($article->url_attachment) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_attachment));
            }
            $attachmentName = $request->file('attachment')->getClientOriginalName();
            $attachmentPath = $request->file('attachment')->storeAs('articles/attachments', $attachmentName, 'public');
            $article->url_attachment = Storage::url($attachmentPath);
            $article->attachment_name = $attachmentName;
        }

        $article->update([
            'judul' => $validated['judul'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'updated_date' => now(),
        ]);

        return redirect()
            ->to('/admin/pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function showPengumuman($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        return inertia('admin/pengumuman/Detail', [
            'article' => $article,
        ]);
    }

    public function destroyPengumuman($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        if ($article->url_thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_thumbnail));
        }

        if ($article->url_attachment) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->url_attachment));
        }

        $article->delete();

        return redirect()
            ->to('/admin/pengumuman')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
