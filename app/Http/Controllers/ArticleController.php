<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(){
        // Menampilkan halaman daftar berita
        $articles = Article::where('type', 'berita')->get();
        return inertia('admin/berita/Index', [
            'articles' => $articles,
        ]);
    }

    public function storeBerita(Request $request)
    {
        var_dump($request->all());
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
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('articles/attachments', 'public');
        }

        // Buat artikel baru
        $article = new Article([
            'url_thumbnail' => $thumbnailPath ? Storage::url($thumbnailPath) : null,
            'url_attachment' => $attachmentPath ? Storage::url($attachmentPath) : null,
            'judul' => $validated['judul'],
            'content' => $validated['content'],
            'type' => 'berita',
            'status' => $validated['status'],
        ]);

        // Karena kita punya UUID primary key, generate manual jika belum ada
        $article->article_id = Str::uuid()->toString();
        $article->created_date = $validated['date']; // gunakan tanggal publikasi dari form
        $article->save();
        // Response
        return redirect()
            ->to('/admin/berita')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function showBerita($id)
    {
        $article = Article::where('article_id', $id)->firstOrFail();

        return inertia('admin/berita/Detail', [
            'article' => $article,
        ]);
    }

}
