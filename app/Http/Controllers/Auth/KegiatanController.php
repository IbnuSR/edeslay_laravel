<?php
// app/Http/Controllers/KegiatanController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    // LIST DATA
    public function index()
    {
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->get();
        return view('auth.kegiatan', compact('kegiatan'));
    }

    // TAMBAH DATA (INI YANG KAMU TIDAK PUNYA)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'foto' => 'nullable|image'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kegiatan', 'public');
        }

       Kegiatan::create([
    'judul' => $request->judul,
    'deskripsi' => $request->deskripsi,
    'tanggal' => $request->tanggal,
    'foto' => $fotoPath,
    'foto_type' => $request->file('foto')?->getMimeType(),
]);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }
}