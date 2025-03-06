<?php
require_once 'gaji.php';



function menu() {
    echo "\n=============================\n";
    echo "  SISTEM MANAJEMEN GAJI\n";
    echo "=============================\n";
    echo "1. Lihat Karyawan\n";
    echo "2. Tambah Karyawan\n";
    echo "3. Update Karyawan\n";
    echo "4. Hapus Karyawan\n";
    echo "5. Hitung Gaji Karyawan\n";
    echo "6. Keluar\n";
    echo "=============================\n";
    echo "Pilih menu: ";
}

while (true) {
    menu();
    $pilihan = trim(fgets(STDIN));

    if (!in_array($pilihan, ['1', '2', '3', '4', '5', '6'])) {
        echo "⚠️ Input tidak valid, silakan pilih angka 1-6!\n";
        continue;
    }

    switch ($pilihan) {
        case '1': lihatKaryawan(); break;
        case '2': tambahKaryawan(); break;
        case '3': updateKaryawan(); break;
        case '4': hapusKaryawan(); break;
        case '5': hitungGaji(); break;
        case '6': 
            echo "Terima kasih, sampai jumpa!\n";
            exit();
    }
}
?>
