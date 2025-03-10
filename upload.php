<?php
include "config.php"; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $target_dir = "uploads/";

    // Pastikan folder uploads ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["fileTugas"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek ukuran file (maksimal 5MB)
    if ($_FILES["fileTugas"]["size"] > 5 * 1024 * 1024) {
        echo "Ukuran file terlalu besar! Maksimal 5MB.";
        exit();
    }

    // Cek jenis file yang diperbolehkan
    $allowed_types = ["pdf", "doc", "docx", "png", "jpg", "jpeg"];
    if (!in_array($file_type, $allowed_types)) {
        echo "Jenis file tidak diizinkan! Hanya PDF, DOC, DOCX, PNG, JPG.";
        exit();
    }

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($_FILES["fileTugas"]["tmp_name"], $target_file)) {
        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO pengumpulan_tugas (nama, email, file_tugas) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $file_name);
        
        if ($stmt->execute()) {
            echo "Tugas berhasil dikirim dan disimpan ke database!<br>";
            echo "Nama: " . htmlspecialchars($nama) . "<br>";
            echo "Email: " . htmlspecialchars($email) . "<br>";
            echo "File: <a href='$target_file' target='_blank'>$file_name</a>";
        } else {
            echo "Gagal menyimpan ke database.";
        }

        $stmt->close();
    } else {
        echo "Gagal mengunggah tugas.";
    }
} else {
    echo "Metode tidak diizinkan.";
}

$conn->close();
?>
