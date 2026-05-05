<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show admin profile page
     */
    public function show()
{
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    // ✅ KEMBALIKAN VARIABEL INI
    $namaAdmin = $user->nama_lengkap ?? 'Administrator';
    $roleAdmin = $user->role ?? 'admin';
    $inisialAdmin = strtoupper(substr($namaAdmin, 0, 1));
    
    $fotoProfilSrc = null;
    if (!empty($user->foto)) {
        $fotoProfilSrc = filter_var($user->foto, FILTER_VALIDATE_URL) 
            ? $user->foto 
            : asset('storage/' . $user->foto);
    }
    
    $fotoSampulSrc = null;
    if (!empty($user->foto_sampul)) {
        $fotoSampulSrc = filter_var($user->foto_sampul, FILTER_VALIDATE_URL) 
            ? $user->foto_sampul 
            : asset('storage/' . $user->foto_sampul);
    }

    return view('admin.profile', compact(
        'user', 'namaAdmin', 'roleAdmin', 'inisialAdmin',
        'fotoProfilSrc', 'fotoSampulSrc'
    ));
}

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        return view('admin.profile-edit', compact('user'));
    }

    /**
     * Update profile (via edit form)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $file = $request->file('foto');
            $filename = 'profile_' . time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $updateData['foto'] = $file->storeAs('profile', $filename, 'public');
        }

        if ($request->hasFile('foto_sampul')) {
            if ($user->foto_sampul && Storage::disk('public')->exists($user->foto_sampul)) {
                Storage::disk('public')->delete($user->foto_sampul);
            }
            $file = $request->file('foto_sampul');
            $filename = 'cover_' . time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
            $updateData['foto_sampul'] = $file->storeAs('covers', $filename, 'public');
        }

        DB::table('users')->where('id', $user->id)->update($updateData);
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $validated = $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min' => 'Password baru minimal 6 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }

        DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($validated['password_baru']),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    /**
     * Upload avatar directly (AJAX)
     */
    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'avatar.required' => 'Pilih gambar terlebih dahulu',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Hapus foto lama
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }
        
        $file = $request->file('avatar');
        $filename = 'profile_' . time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs('profile', $filename, 'public');

        DB::table('users')->where('id', $user->id)->update([
            'foto' => $path,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Foto profil berhasil diubah',
            'foto_url' => asset('storage/' . $path)
        ]);
    }

    /**
     * Upload cover directly (AJAX)
     */
    public function uploadCover(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'cover.required' => 'Pilih gambar terlebih dahulu',
            'cover.image' => 'File harus berupa gambar',
            'cover.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        // Hapus cover lama
        if ($user->foto_sampul && Storage::disk('public')->exists($user->foto_sampul)) {
            Storage::disk('public')->delete($user->foto_sampul);
        }
        
        $file = $request->file('cover');
        $filename = 'cover_' . time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs('covers', $filename, 'public');

        DB::table('users')->where('id', $user->id)->update([
            'foto_sampul' => $path,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Foto cover berhasil diubah',
            'foto_sampul_url' => asset('storage/' . $path)
        ]);
    }
}