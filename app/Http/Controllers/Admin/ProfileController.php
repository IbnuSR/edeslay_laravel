<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show profile page (view only).
     */
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Data profil
        $namaAdmin = $user->nama_lengkap ?? 'Administrator';
        $username = $user->username ?? '-';
        $email = $user->email ?? '-';
        $jenis_kelamin = $user->jenis_kelamin ?? '-';
        $no_telp = $user->no_telp ?? '-';
        $alamat = $user->alamat ?? '-';
        
        $fotoProfilSrc = !empty($user->foto) 
            ? 'data:image/jpeg;base64,' . base64_encode($user->foto) 
            : asset('assets/images/default.png');
        
        $coverSrc = !empty($user->cover) 
            ? 'data:image/jpeg;base64,' . base64_encode($user->cover) 
            : asset('assets/images/cover-default.jpg');

        return view('admin.profile', compact(
            'namaAdmin', 'username', 'email', 'jenis_kelamin', 
            'no_telp', 'alamat', 'fotoProfilSrc', 'coverSrc'
        ));
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('admin.edit_profile', compact('user'));
    }

    /**
     * Update profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'jenis_kelamin' => 'nullable|in:Laki-Laki,Perempuan',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Update data teks
        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'updated_at' => now(),
        ];

        // Handle upload foto profil (jika ada)
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $imgData = file_get_contents($file->getRealPath());
            $updateData['foto'] = $imgData;
        }

        // Eksekusi update
        DB::table('users')->where('id', $user->id)->update($updateData);

        return redirect()->route('admin.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update cover image only.
     */
    public function updateCover(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'cover.required' => 'Silakan pilih gambar cover.',
            'cover.image' => 'File harus berupa gambar.',
            'cover.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'cover.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $file = $request->file('cover');
            $imgData = file_get_contents($file->getRealPath());
            
            DB::table('users')->where('id', $user->id)->update([
                'cover' => $imgData,
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Cover profil berhasil diperbarui.');
    }
}