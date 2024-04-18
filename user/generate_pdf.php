<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sertifikat_online";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Panggil library FPDF
require('../fpdf/fpdf.php');

// Buat objek FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Judul
$pdf->Cell(0, 10, 'Certificates', 0, 1, 'C');

// Tabel Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(30, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Participant Name', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Event Name', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Event Date', 1, 0, 'C', true);
$pdf->Ln();

// Query untuk mendapatkan data sertifikat
$sql_certificates = "SELECT * FROM certificates";
$result_certificates = $conn->query($sql_certificates);

// Periksa apakah ada sertifikat yang ditemukan
if ($result_certificates->num_rows > 0) {
    // Output data sertifikat ke dalam baris tabel
    while ($row = $result_certificates->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30, 10, $row['certificate_id'], 1, 0, 'C');
        $pdf->Cell(60, 10, $row['participant_name'], 1);
        $pdf->Cell(60, 10, $row['event_name'], 1);
        $pdf->Cell(40, 10, $row['event_date'], 1, 0, 'C');
        $pdf->Ln();
    }
} else {
    // Jika tidak ada sertifikat yang ditemukan
    $pdf->Cell(0, 10, 'No certificates found', 0, 1, 'C');
}

// Menutup koneksi database
$conn->close();

// Output PDF ke browser dengan nama file "certificates.pdf"
$pdf->Output('D', 'certificates.pdf');
?>
