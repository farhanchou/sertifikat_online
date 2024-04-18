<?php
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $certificate_id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sertifikat_online";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $sql_certificate_detail = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
    $sql_certificate_detail->bind_param("i", $certificate_id);
    $sql_certificate_detail->execute();
    $result_certificate_detail = $sql_certificate_detail->get_result();

    if ($result_certificate_detail->num_rows > 0) {
        $certificate = $result_certificate_detail->fetch_assoc();
        
        require('../fpdf/fpdf.php');
        ob_start();
        
        $pdf = new FPDF();
        $pdf->AddPage();

        // Tambahkan latar belakang
        $pdf->Image('../assets/images/th.jpg', 0, 0, 210, 150); // Sesuaikan path dan ukuran gambar latar belakang
        
        // Header Sertifikat
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, 'Sertifikat Kelulusan', 0, 1, 'C');
        $pdf->Ln(10); // Spasi
        
        // Logo (contoh)
        
        
        // Informasi Sertifikat
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 10, 'Dengan ini menyatakan bahwa', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 10, $certificate['participant_name'], 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'telah berhasil menyelesaikan', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 10, $certificate['event_name'], 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Cell(0, 10, 'yang diselenggarakan pada ' . $certificate['event_date'], 0, 1, 'C');
        $pdf->Ln(15); // Spasi
        
        // Tanda Tangan
        $pdf->Cell(0, 10, 'Tanda tangan: ________________________', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Tanggal: ' . date('Y-m-d'), 0, 1, 'L');

        $pdf->Output();
        ob_end_flush();
    } else {
        echo "Sertifikat tidak ditemukan.";
    }

    $conn->close();
} else {
    echo "ID Sertifikat tidak ditemukan atau tidak valid.";
}
?>
