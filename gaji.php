<?php

// === BAGIAN FUNGSI (JANGAN DIHAPUS) ===

if (!function_exists('getData')) {
    function getData() {
        $data = @include __FILE__;
        return is_array($data) ? $data : [];
    }
}

if (!function_exists('saveData')) {
    function saveData($data) {
        $file = __FILE__;

        // Ambil isi file
        $fileContent = file_get_contents($file);

        // Hapus semua blok "return array(...);" sebelumnya (termasuk komentar)
        $fileContent = preg_replace('/\/\/ === DATA KARYAWAN ===\s*return\s+array\s*\(.*?\);\s*/s', '', $fileContent);

        // Tambahkan kembali tanda komentar dan simpan data baru
        $fileContent = rtrim($fileContent) . "\n\n// === DATA KARYAWAN ===\n";
        $fileContent .= "return " . var_export($data, true) . ";\n";

        // Tulis ulang file dengan data terbaru
        
    }
}

if (!function_exists('lihatKaryawan')) {
    function lihatKaryawan() {
        $data = getData();
        echo "\n=== Daftar Karyawan ===\n";

        if (empty($data)) {
            echo "Belum ada karyawan terdaftar.\n";
        } else {
            foreach ($data as $index => $karyawan) {
                echo ($index + 1) . ". {$karyawan['nama']} - {$karyawan['jabatan']}\n";
            }
        }
        echo "========================\n";
    }
}

if (!function_exists('tambahKaryawan')) {
    function tambahKaryawan() {
        echo "Masukkan nama karyawan: ";
        $nama = trim(fgets(STDIN));

        while (true) {
            echo "Masukkan jabatan (Manajer/Supervisor/Staf): ";
            $jabatan = trim(fgets(STDIN));

            $jabatan_valid = ['Manajer', 'Supervisor', 'Staf'];

            if (in_array($jabatan, $jabatan_valid)) {
                break;
            }

            echo "⚠️ Jabatan tidak valid! Pilih Manajer, Supervisor, atau Staf.\n";
        }

        $data = getData();
        $data[] = ['nama' => $nama, 'jabatan' => $jabatan];

        saveData($data);
        echo "✅ Karyawan berhasil ditambahkan!\n";
    }
}

if (!function_exists('updateKaryawan')) {
    function updateKaryawan() {
        $data = getData();
        lihatKaryawan();

        echo "Pilih nomor karyawan yang ingin diupdate: ";
        $index = (int)trim(fgets(STDIN)) - 1;

        if (!isset($data[$index])) {
            echo "⚠️ Nomor karyawan tidak ditemukan!\n";
            return;
        }

        echo "Masukkan nama baru: ";
        $data[$index]['nama'] = trim(fgets(STDIN));

        echo "Masukkan jabatan baru (Manajer/Supervisor/Staf): ";
        $jabatan = trim(fgets(STDIN));

        if (!in_array($jabatan, ['Manajer', 'Supervisor', 'Staf'])) {
            echo "⚠️ Jabatan tidak valid!\n";
            return;
        }

        $data[$index]['jabatan'] = $jabatan;
        saveData($data);
        echo "✅ Data karyawan berhasil diperbarui!\n";
    }
}

if (!function_exists('hapusKaryawan')) {
    function hapusKaryawan() {
        $data = getData();
        lihatKaryawan();

        echo "Pilih nomor karyawan yang ingin dihapus: ";
        $index = (int)trim(fgets(STDIN)) - 1;

        if (!isset($data[$index])) {
            echo "⚠️ Nomor karyawan tidak ditemukan!\n";
            return;
        }

        echo "Apakah yakin ingin menghapus? (y/n): ";
        $konfirmasi = trim(fgets(STDIN));
        if (strtolower($konfirmasi) !== 'y') {
            echo "Penghapusan dibatalkan.\n";
            return;
        }

        unset($data[$index]);
        saveData(array_values($data));
        echo "✅ Karyawan berhasil dihapus!\n";
    }
}

if (!function_exists('hitungGaji')) {
    function hitungGaji() {
        $data = getData();
        lihatKaryawan();

        echo "Pilih nomor karyawan untuk menghitung gaji: ";
        $index = (int)trim(fgets(STDIN)) - 1;

        if (!isset($data[$index])) {
            echo "⚠️ Nomor karyawan tidak ditemukan!\n";
            return;
        }

        echo "Masukkan jumlah jam lembur: ";
        $lembur = (int)trim(fgets(STDIN));

        echo "Masukkan rating kinerja (1-5): ";
        $rating = (int)trim(fgets(STDIN));

        if ($rating < 1 || $rating > 5) {
            echo "⚠️ Rating tidak valid!\n";
            return;
        }

        $gaji_pokok = ['Manajer' => 5000000, 'Supervisor' => 4000000, 'Staf' => 3000000];
        $tunjangan_jabatan = ['Manajer' => 1000000, 'Supervisor' => 750000, 'Staf' => 500000];
        $bonus_kinerja = [1 => 0, 2 => 200000, 3 => 400000, 4 => 600000, 5 => 800000];

        $jabatan = $data[$index]['jabatan'];

        $total_gaji = $gaji_pokok[$jabatan] + $tunjangan_jabatan[$jabatan] + ($lembur * 25000) + $bonus_kinerja[$rating];

        echo "\n==============================\n";
        echo "       💰 Gaji Karyawan 💰       \n";
        echo "==============================\n";
        echo "Nama          : {$data[$index]['nama']}\n";
        echo "Jabatan       : {$jabatan}\n";
        echo "Gaji Pokok    : Rp " . number_format($gaji_pokok[$jabatan], 0, ',', '.') . "\n";
        echo "Tunjangan     : Rp " . number_format($tunjangan_jabatan[$jabatan], 0, ',', '.') . "\n";
        echo "Jam Lembur    : {$lembur} x Rp 25.000\n";
        echo "Lembur        : Rp " . number_format($lembur * 25000, 0, ',', '.') . "\n";
        echo "Bonus Kinerja : Rp " . number_format($bonus_kinerja[$rating], 0, ',', '.') . "\n";
        echo "------------------------------\n";
        echo "Total Gaji    : Rp " . number_format($total_gaji, 0, ',', '.') . "\n";
        echo "==============================\n";
    }
}


// === DATA KARYAWAN ===
return array (
  0 => 
  array (
    'nama' => 'Jhon Doe',
    'jabatan' => 'Staf',
  ),
  1 => 
  array (
    'nama' => 'Jane Smith',
    'jabatan' => 'Supervisor',
  ),
);
