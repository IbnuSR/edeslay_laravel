@extends('layouts.app')

@section('content')

{{-- Cropper.js CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<style>
    /* ===== PROFILE CONTAINER ===== */
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ===== COVER PHOTO ===== */
    .profile-cover {
        position: relative;
        height: 250px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 80px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .profile-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-cover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        cursor: pointer;
    }

    .profile-cover:hover .profile-cover-overlay {
        opacity: 1;
    }

    .profile-cover-overlay span {
        color: white;
        font-size: 16px;
        font-weight: 600;
        background: rgba(0, 0, 0, 0.6);
        padding: 10px 20px;
        border-radius: 8px;
    }

    /* ===== PROFILE HEADER ===== */
    .profile-header {
        display: flex;
        align-items: flex-end;
        margin: -60px 20px 20px 20px;
        position: relative;
        z-index: 10;
    }

    .profile-avatar-wrapper {
        position: relative;
        margin-right: 30px;
        cursor: pointer;
    }

    .profile-avatar-large {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        background: #f3f4f6;
        transition: opacity 0.3s;
    }

    .profile-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        font-weight: bold;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .profile-avatar-edit {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        background: #3b82f6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: 3px solid white;
        transition: transform 0.2s;
    }

    .profile-avatar-edit:hover {
        transform: scale(1.1);
    }

    .profile-info {
        flex: 1;
        padding-bottom: 20px;
    }

    .profile-name {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 5px 0;
    }

    .profile-role {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    .profile-actions {
        padding-bottom: 20px;
    }

    .btn-edit-profile {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    /* ===== PROFILE CONTENT ===== */
    .profile-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        padding: 20px;
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #f3f4f6;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 16px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .info-row:hover {
        background: #f3f4f6;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 15px;
        color: #1f2937;
        font-weight: 500;
    }

    /* ===== ALERT ===== */
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ===== CROP MODAL ===== */
    .crop-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .crop-container {
        background: white;
        padding: 30px;
        border-radius: 16px;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }

    .crop-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .crop-image-wrapper {
        height: 500px;
        background: #333;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
        position: relative;
    }

    .crop-image-wrapper img {
        max-width: 100%;
        display: block;
    }

    .crop-hints {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
        padding: 12px;
        background: #f3f4f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .crop-actions {
        display: flex;
        gap: 10px;
        justify-content: space-between;
    }

    .crop-actions-right {
        display: flex;
        gap: 10px;
    }

    .btn-crop {
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-crop-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-crop-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-crop-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-crop-secondary:hover {
        background: #d1d5db;
    }

    .btn-crop-skip {
        background: #10b981;
        color: white;
    }

    .btn-crop-skip:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-content {
            grid-template-columns: 1fr;
        }
        
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: -60px 10px 10px 10px;
        }
        
        .profile-avatar-wrapper {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .profile-actions {
            margin-top: 15px;
        }

        .crop-image-wrapper {
            height: 300px;
        }

        .crop-actions {
            flex-direction: column;
        }

        .crop-actions-right {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="profile-container">
    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Cover Photo --}}
    <div class="profile-cover" id="coverArea">
        @if($fotoSampulSrc)
            <img src="{{ $fotoSampulSrc }}" alt="Cover Photo" id="coverImage">
        @else
            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" id="coverPlaceholder"></div>
        @endif
        <div class="profile-cover-overlay">
            <span><i class="fas fa-camera"></i> Ubah Cover</span>
        </div>
    </div>

    {{-- Profile Header --}}
    <div class="profile-header">
        <div class="profile-avatar-wrapper" id="avatarArea">
            <div class="profile-avatar-large">
                @if($fotoProfilSrc)
                    <img src="{{ $fotoProfilSrc }}" alt="Profile" id="avatarImage">
                @else
                    <div class="profile-avatar-placeholder" id="avatarPlaceholder">
                        {{ $inisialAdmin }}
                    </div>
                @endif
            </div>
            <div class="profile-avatar-edit">
                <i class="fas fa-camera"></i>
            </div>
        </div>

        <div class="profile-info">
            <h1 class="profile-name">{{ $namaAdmin }}</h1>
            <p class="profile-role">{{ ucfirst($roleAdmin) }}</p>
        </div>

        <div class="profile-actions">
            <a href="{{ route('admin.profile.edit') }}" class="btn-edit-profile">
                <i class="fas fa-edit"></i>
                Edit Profil
            </a>
        </div>
    </div>

    {{-- Profile Content --}}
    <div class="profile-content">
        {{-- Informasi Pribadi --}}
        <div class="profile-card">
            <h2 class="card-title">
                <i class="fas fa-user-circle" style="margin-right: 8px;"></i>
                Informasi Pribadi
            </h2>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Username</div>
                    <div class="info-value">{{ $user->username ?? '-' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $user->email ?? '-' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $user->no_telepon ?? '-' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $user->alamat ?? '-' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Terdaftar Sejak</div>
                    <div class="info-value">
                       {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d F Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="profile-card">
            <h2 class="card-title">
                <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                Keamanan Akun
            </h2>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Role</div>
                    <div class="info-value">
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                            {{ ucfirst($roleAdmin) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Terdaftar Sejak</div>
                    <div class="info-value">
                       {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d F Y') : '-' }}
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Terakhir Update</div>
                    <div class="info-value">
                       {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d F Y, H:i') : '-' }}
                    </div>
                </div>
            </div>

            <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #f3f4f6;">
                <button class="btn-edit-profile" onclick="showChangePasswordModal()" style="width: 100%; justify-content: center;">
                    <i class="fas fa-key"></i>
                    Ubah Password
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden file inputs --}}
<input type="file" id="avatarInput" style="display: none;" accept="image/*">
<input type="file" id="coverInput" style="display: none;" accept="image/*">

{{-- Crop Modal --}}
<div id="cropModal" class="crop-modal">
    <div class="crop-container">
        <h3 class="crop-title">
            <i class="fas fa-crop-alt" style="margin-right: 8px;"></i>
            Sesuaikan Posisi Gambar
        </h3>
        <div class="crop-hints">
            <i class="fas fa-info-circle" style="margin-right: 5px;"></i>
            Geser dan zoom gambar untuk menyesuaikan area yang ingin ditampilkan. Atau klik "Langsung Upload" untuk pakai gambar asli tanpa crop.
        </div>
        <div class="crop-image-wrapper">
            <img id="cropImage" src="" alt="Crop preview">
        </div>
        <div class="crop-actions">
            <button type="button" class="btn-crop btn-crop-skip" onclick="uploadWithoutCrop()">
                <i class="fas fa-upload"></i> Langsung Upload
            </button>
            <div class="crop-actions-right">
                <button type="button" class="btn-crop btn-crop-secondary" onclick="closeCropModal()">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn-crop btn-crop-primary" onclick="cropAndUpload()">
                    <i class="fas fa-check"></i> Potong & Upload
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Change Password --}}
<div id="changePasswordModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 16px; max-width: 450px; width: 90%;">
        <h3 style="margin: 0 0 20px 0; font-size: 20px;">
            <i class="fas fa-key" style="margin-right: 8px;"></i>
            Ubah Password
        </h3>
        <form method="POST" action="{{ route('admin.profile.password') }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;" required>
                @error('password_lama')
                    <small style="color: red; font-size: 12px;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;" required>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closeChangePasswordModal()" style="flex: 1; padding: 10px; background: #e5e7eb; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Batal</button>
                <button type="submit" style="flex: 1; padding: 10px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Cropper.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
let cropper;
let currentUploadType = ''; // 'avatar' atau 'cover'
let currentFile = null;

// ===== CLICK AVATAR TO UPLOAD =====
document.getElementById('avatarArea').addEventListener('click', function(e) {
    if (e.target.closest('.btn-edit-profile')) return;
    document.getElementById('avatarInput').click();
});

document.getElementById('avatarInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        currentUploadType = 'avatar';
        currentFile = this.files[0];
        openCropModal(this.files[0]);
    }
});

// ===== CLICK COVER TO UPLOAD =====
document.getElementById('coverArea').addEventListener('click', function(e) {
    if (e.target.closest('.profile-cover-overlay')) {
        document.getElementById('coverInput').click();
    }
});

document.getElementById('coverInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        currentUploadType = 'cover';
        currentFile = this.files[0];
        openCropModal(this.files[0]);
    }
});

// ===== OPEN CROP MODAL =====
function openCropModal(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const cropImage = document.getElementById('cropImage');
        cropImage.src = e.target.result;
        
        const modal = document.getElementById('cropModal');
        modal.style.display = 'flex';
        
        // Initialize cropper after modal is shown
        setTimeout(() => {
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(cropImage, {
                aspectRatio: currentUploadType === 'avatar' ? 1 : 16/9, // Avatar: square, Cover: wide
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1, // Full gambar by default
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        }, 100);
    };
    reader.readAsDataURL(file);
}

// ===== CLOSE CROP MODAL =====
function closeCropModal() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    document.getElementById('cropModal').style.display = 'none';
    currentUploadType = '';
    currentFile = null;
}

// ===== UPLOAD WITHOUT CROP =====
// ===== UPLOAD WITHOUT CROP =====
function uploadWithoutCrop() {
    if (!currentFile) return;

    const formData = new FormData();
    formData.append(currentUploadType === 'avatar' ? 'avatar' : 'cover', currentFile);
    // ✅ HAPUS: formData.append('_token', ...) ← tidak works dengan FormData+fetch
    
    const url = currentUploadType === 'avatar' 
        ? '{{ route("admin.profile.upload-avatar") }}'
        : '{{ route("admin.profile.upload-cover") }}';
    
    // ✅ Ambil CSRF token dari meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Show loading
    const btn = document.querySelector('.btn-crop-skip');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,  // ✅ Token di HEADER, bukan body
            'Accept': 'application/json'  // ✅ Pastikan response JSON
        },
        body: formData  // ✅ Jangan set Content-Type, browser otomatis set multipart/form-data
    })
    .then(async res => {
        // ✅ Cek jika response bukan JSON (misal HTML error page)
        const contentType = res.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response bukan JSON. Server mungkin return error page.');
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            if (currentUploadType === 'avatar') {
                updateAvatarDisplay(data.foto_url);
            } else {
                updateCoverDisplay(data.foto_sampul_url);
            }
            showNotification('success', data.message);
            closeCropModal();
        } else {
            showNotification('error', data.message || 'Gagal upload');
        }
    })
    .catch(err => {
        console.error('Upload error:', err);
        showNotification('error', 'Terjadi kesalahan: ' + err.message);
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// ===== CROP AND UPLOAD =====
// ===== CROP AND UPLOAD =====
function cropAndUpload() {
    if (!cropper) return;
    
    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
        maxWidth: 2048,
        maxHeight: 2048,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });
    
    // Convert to blob
    canvas.toBlob(function(blob) {
        const formData = new FormData();
        formData.append(currentUploadType === 'avatar' ? 'avatar' : 'cover', blob, 'cropped.jpg');
        // ✅ HAPUS: formData.append('_token', ...)
        
        const url = currentUploadType === 'avatar' 
            ? '{{ route("admin.profile.upload-avatar") }}'
            : '{{ route("admin.profile.upload-cover") }}';
        
        // ✅ Ambil CSRF token dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Show loading
        const btn = document.querySelector('#cropModal .btn-crop-primary');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        btn.disabled = true;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,  // ✅ Token di HEADER
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            const contentType = res.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response bukan JSON. Server mungkin return error page.');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                if (currentUploadType === 'avatar') {
                    updateAvatarDisplay(data.foto_url);
                } else {
                    updateCoverDisplay(data.foto_sampul_url);
                }
                showNotification('success', data.message);
                closeCropModal();
            } else {
                showNotification('error', data.message || 'Gagal upload');
                resetCropButtons();
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            showNotification('error', 'Terjadi kesalahan: ' + err.message);
            resetCropButtons();
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }, 'image/jpeg', 0.9);
}

// ===== UPDATE AVATAR DISPLAY =====
function updateAvatarDisplay(url) {
    let avatarImg = document.getElementById('avatarImage');
    const placeholder = document.getElementById('avatarPlaceholder');
    
    if (!avatarImg && placeholder) {
        placeholder.remove();
        avatarImg = document.createElement('img');
        avatarImg.id = 'avatarImage';
        avatarImg.alt = 'Profile';
        avatarImg.style.cssText = 'width:100%;height:100%;object-fit:cover;';
        document.querySelector('.profile-avatar-large').appendChild(avatarImg);
    }
    
    if (avatarImg) {
        avatarImg.src = url + '?t=' + Date.now();
    }
}

// ===== UPDATE COVER DISPLAY =====
function updateCoverDisplay(url) {
    let coverImg = document.getElementById('coverImage');
    const placeholder = document.getElementById('coverPlaceholder');
    
    if (!coverImg && placeholder) {
        placeholder.remove();
        coverImg = document.createElement('img');
        coverImg.id = 'coverImage';
        coverImg.alt = 'Cover Photo';
        coverImg.style.cssText = 'width:100%;height:100%;object-fit:cover;';
        document.getElementById('coverArea').insertBefore(coverImg, document.getElementById('coverArea').firstChild);
    }
    
    if (coverImg) {
        coverImg.src = url + '?t=' + Date.now();
    }
}

// ===== RESET CROP BUTTONS =====
function resetCropButtons() {
    const modal = document.getElementById('cropModal');
    modal.querySelector('.crop-actions').innerHTML = `
        <button type="button" class="btn-crop btn-crop-skip" onclick="uploadWithoutCrop()">
            <i class="fas fa-upload"></i> Langsung Upload
        </button>
        <div class="crop-actions-right">
            <button type="button" class="btn-crop btn-crop-secondary" onclick="closeCropModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button type="button" class="btn-crop btn-crop-primary" onclick="cropAndUpload()">
                <i class="fas fa-check"></i> Potong & Upload
            </button>
        </div>
    `;
}

// ===== NOTIFICATION =====
function showNotification(type, message) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
    alert.style.cssText = `
        position: fixed; top: 20px; right: 20px; z-index: 10001;
        min-width: 300px; padding: 12px 20px; border-radius: 8px;
        background: ${type === 'success' ? '#dcfce7' : '#fee2e2'};
        color: ${type === 'success' ? '#166534' : '#991b1b'};
        border: 1px solid ${type === 'success' ? '#86efac' : '#fecaca'};
        display: flex; align-items: center; gap: 10px;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    alert.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${message}`;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}

// ===== MODAL PASSWORD =====
function showChangePasswordModal() {
    document.getElementById('changePasswordModal').style.display = 'flex';
}
function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').style.display = 'none';
}
document.getElementById('changePasswordModal').addEventListener('click', function(e) {
    if (e.target === this) closeChangePasswordModal();
});

// Close crop modal on outside click
document.getElementById('cropModal').addEventListener('click', function(e) {
    if (e.target === this) closeCropModal();
});

// Add animation CSS
if (!document.getElementById('profile-anim-style')) {
    const style = document.createElement('style');
    style.id = 'profile-anim-style';
    style.textContent = `
        @keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }
    `;
    document.head.appendChild(style);
}
</script>

@endsection
