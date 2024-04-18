<?php
// Sertakan file FPDF
require('../fpdf/fpdf.php');

// Panggil koneksi ke database
include '../includes/koneksi.php';

// Buat objek FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Query untuk mendapatkan data sertifikat
if (isset($_GET['certificate_id'])) {
    // Ambil certificate_id dari parameter URL
    $certificate_id = $_GET['certificate_id'];

    // Query untuk mendapatkan data sertifikat berdasarkan certificate_id
    $sql_certificate = "SELECT * FROM certificates WHERE certificate_id = $certificate_id";
    $result_certificate = $conn->query($sql_certificate);

    if ($result_certificate->num_rows > 0) {
        // Ambil data sertifikat
        $row = $result_certificate->fetch_assoc();
        $participant_name = $row['participant_name'];
        $event_name = $row['event_name'];
        $event_date = $row['event_date'];
        $certificate_text = $row['certificate_text'];

        // Tambahkan informasi sertifikat ke dalam file PDF
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Detail Sertifikat',0,1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,'Participant Name: '.$participant_name,0,1);
        $pdf->Cell(0,10,'Event Name: '.$event_name,0,1);
        $pdf->Cell(0,10,'Event Date: '.$event_date,0,1);
        $pdf->Cell(0,10,'Certificate Text: '.$certificate_text,0,1);

        // Output file PDF
        $pdf->Output('D', 'certificate_'.$certificate_id.'.pdf'); // Download file PDF dengan nama certificate_ID.pdf
        exit;
    } else {
        echo "Certificate not found.";
    }
} else {
    echo "Certificate ID not provided.";
}
?>
