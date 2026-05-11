<?php

namespace App\Imports;

use App\Models\Penduduk;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class PendudukImport
{
    /**
     * Import file Excel/CSV menggunakan FastExcel
     * 
     * @param string|\Illuminate\Http\UploadedFile $file
     * @return array ['success' => int, 'errors' => array]
     */
    public function import($file): array
    {
        $successCount = 0;
        $errors = [];

        try {
            /** @var FastExcel $fastExcel */
            $path = is_string($file) ? $file : null;
            if ($path === null && method_exists($file, 'getRealPath')) {
                $path = $file->getRealPath();
            }
            if ($path === false || $path === null) {
                if (method_exists($file, 'getPathname')) {
                    $path = $file->getPathname();
                }
            }
            if (!is_string($path) || !file_exists($path)) {
                throw new \InvalidArgumentException('File path tidak valid');
            }

            $fastExcel = new FastExcel();
            
            $rows = $fastExcel->import($path);
            
            $rows->chunk(100)->each(function (Collection $rows) use (&$successCount, &$errors) {
                    foreach ($rows as $index => $row) {
                        $rowNumber = $index + 2; // +2 karena header + 0-based index
                        
                        try {
                            $data = $this->mapRow($row);
                            
                            if ($this->validateRow($data, $rowNumber, $errors)) {
                                // Cek duplikat NIK
                                if (Penduduk::where('nik', $data['nik'])->exists()) {
                                    $errors[] = "Baris {$rowNumber}: NIK {$data['nik']} sudah terdaftar";
                                    continue;
                                }
                                
                                Penduduk::create($data);
                                $successCount++;
                            }
                        } catch (\Exception $e) {
                            $errors[] = "Baris {$rowNumber}: " . $e->getMessage();
                        }
                    }
                });

        } catch (\Exception $e) {
            return [
                'success' => 0,
                'errors' => ['Gagal memproses file: ' . $e->getMessage()]
            ];
        }

        return [
            'success' => $successCount,
            'errors' => $errors
        ];
    }

    /**
     * Map Excel columns to database fields
     */
    private function mapRow(array $row): array
    {
        return [
            'nik' => $this->cleanString($row['nik'] ?? $row['NIK'] ?? ''),
            'nama' => $this->cleanString($row['nama_lengkap'] ?? $row['Nama Lengkap'] ?? $row['nama'] ?? $row['Nama'] ?? ''),
            'jenis_kelamin' => $this->parseJenisKelamin($row['jenis_kelamin'] ?? $row['Jenis Kelamin'] ?? $row['JK'] ?? 'L'),
            'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? $row['Tanggal Lahir'] ?? $row['Tgl Lahir'] ?? null),
            'pendidikan' => $this->cleanString($row['pendidikan'] ?? $row['Pendidikan'] ?? $row['pendidikan_terakhir'] ?? $row['Pendidikan Terakhir'] ?? ''),
            'pekerjaan' => $this->cleanString($row['pekerjaan'] ?? $row['Pekerjaan'] ?? ''),
            'status_perkawinan' => $this->cleanString($row['status_perkawinan'] ?? $row['Status Perkawinan'] ?? $row['Status Kawin'] ?? ''),
            'kawin_tercatat' => $this->parseBoolean($row['kawin_tercatat'] ?? $row['Kawin Tercatat'] ?? $row['Tercatat'] ?? null),
            'dusun' => $this->cleanString($row['dusun'] ?? $row['Dusun'] ?? ''),
            'status_keluarga' => $this->cleanString($row['status_keluarga'] ?? $row['Status Keluarga'] ?? $row['Status'] ?? 'Anggota'),
        ];
    }

    /**
     * Validate row data before insert
     */
    private function validateRow(array $row, int $rowNumber, array &$errors): bool
    {
        $isValid = true;

        // NIK: wajib 16 digit angka
        if (!preg_match('/^\d{16}$/', $row['nik'] ?? '')) {
            $errors[] = "Baris {$rowNumber}: NIK harus 16 digit angka";
            $isValid = false;
        }

        // Nama: wajib ada
        if (empty($row['nama'])) {
            $errors[] = "Baris {$rowNumber}: Nama lengkap wajib diisi";
            $isValid = false;
        }

        // Jenis kelamin: wajib L atau P
        if (!in_array($row['jenis_kelamin'], ['L', 'P'])) {
            $errors[] = "Baris {$rowNumber}: Jenis kelamin harus L atau P";
            $isValid = false;
        }

        // Tanggal lahir: wajib valid dan sebelum hari ini
        if (empty($row['tanggal_lahir'])) {
            $errors[] = "Baris {$rowNumber}: Tanggal lahir wajib diisi";
            $isValid = false;
        } elseif (strtotime($row['tanggal_lahir']) >= strtotime('today')) {
            $errors[] = "Baris {$rowNumber}: Tanggal lahir tidak boleh hari ini atau masa depan";
            $isValid = false;
        }

        // Pendidikan: wajib ada
        if (empty($row['pendidikan'])) {
            $errors[] = "Baris {$rowNumber}: Pendidikan wajib diisi";
            $isValid = false;
        }

        // Status perkawinan: wajib valid
        $validStatus = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
        if (!in_array($row['status_perkawinan'], $validStatus)) {
            $errors[] = "Baris {$rowNumber}: Status perkawinan tidak valid";
            $isValid = false;
        }

        return $isValid;
    }

    // ===== HELPER FUNCTIONS =====

    private function cleanString($value): ?string
    {
        if (empty($value)) return null;
        return trim(preg_replace('/\s+/', ' ', (string) $value));
    }

    private function parseJenisKelamin($value): string
    {
        $val = strtoupper(trim((string) $value));
        if (in_array($val, ['L', 'LAKI-LAKI', 'LAKI', 'PRIA'])) return 'L';
        if (in_array($val, ['P', 'PEREMPUAN', 'WANITA'])) return 'P';
        return 'L'; // Default
    }

    private function parseDate($value): ?string
    {
        if (empty($value)) return null;
        
        // Jika sudah DateTime object
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }
        
        // Jika Excel date serial number (angka besar seperti 43831)
        // Excel menghitung dari 1 Januari 1900
        if (is_numeric($value) && $value > 10000) {
            try {
                // Konversi Excel serial ke timestamp
                // 25569 adalah selisih hari antara 1 Jan 1900 dan 1 Jan 1970 (Unix epoch)
                $unixDate = ($value - 25569) * 86400;
                return date('Y-m-d', $unixDate);
            } catch (\Exception $e) {
                // Fallback ke parsing string
            }
        }
        
        // Coba berbagai format tanggal
        $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'Y/m/d', 'd F Y', 'j/n/Y', 'n/j/Y'];
        foreach ($formats as $format) {
            try {
                $date = \DateTime::createFromFormat($format, (string) $value);
                if ($date) {
                    return $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        
        return null;
    }

    private function parseBoolean($value): ?string
    {
        if (empty($value)) return null;
        $val = strtolower(trim((string) $value));
        if (in_array($val, ['ya', 'yes', 'y', '1', 'true', 'tercatat'])) return 'Ya';
        if (in_array($val, ['tidak', 'no', 'n', '0', 'false', 'belum'])) return 'Tidak';
        return null;
    }
}