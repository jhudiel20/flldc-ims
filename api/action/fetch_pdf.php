<?php
// URL of the PDF on GitHub
$fileUrl = 'https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/PO_ATTACHMENTS/' . $_GET['file'];

// Fetch the content of the PDF file
$pdfContent = file_get_contents($fileUrl);

// Check if the content was fetched successfully
if ($pdfContent === false) {
    header('HTTP/1.0 404 Not Found');
    echo 'Error: Unable to access the PDF file.';
    exit;
}

// Set headers to display the PDF inline
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($fileUrl) . '"');

// Output the PDF content
echo $pdfContent;
?>
