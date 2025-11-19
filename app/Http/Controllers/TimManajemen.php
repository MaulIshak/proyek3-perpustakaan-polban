<?php

namespace App\Http\Controllers;

use App\Models\TeamManajemen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimManajemen extends Controller
{
    public function timManajemen()
    {
        $data = [
            'title' => 'Tim Manajemen',
            'manajemen' => TeamManajemen::all(),
        ];

        return Inertia::render('user/Profile/TimManajemen', $data);
    }

    public function TmAdminPage()
    {
        $data = [
            'title' => 'Tim Manajemen',
            'manajemen' => TeamManajemen::orderBy('id_team', 'asc')->get(),
        ];

        return Inertia::render('admin/TimManajemen/Index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
        ]);

        TeamManajemen::create($request->all());

        return redirect()->back()->with('success', 'Data tim berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
        ]);

        $team = TeamManajemen::findOrFail($id);
        $team->update($request->all());

        return redirect()->back()->with('success', 'Data tim berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $team = TeamManajemen::findOrFail($id);
        $team->delete();

        return redirect()->back()->with('success', 'Data tim berhasil dihapus.');
    }
}
