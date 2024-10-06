<?php

$owner = getenv('GITHUB_OWNER');
$repo = getenv('GITHUB_IMAGES');

$db = $_GET['db'];

// URL of the PDF on GitHub
$fileUrl = "https://raw.githubusercontent.com/$owner/$repo/main/$db/" . $_GET['file'];

// Fetch the content of the PDF file
$pdfContent = file_get_contents($fileUrl);

// Check if the content was fetched successfully
if ($pdfContent === false) {
    header('HTTP/1.0 404 Not Found');
    echo 'Error: Unable to access the PDF file.';
    exit;
}
// Determine the file extension
$fileExtension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
// Set the correct Content-Type header based on the file extension
switch ($fileExtension) {
    case 'pdf':
        header('Content-Type: application/pdf');
        break;
    case 'png':
        header('Content-Type: image/png');
        break;
    case 'jpg':
    case 'jpeg':
        header('Content-Type: image/jpeg');
        break;
    default:
        header('HTTP/1.0 415 Unsupported Media Type');
        echo 'Error: Unsupported file type.';
        exit;
}

header('Content-Disposition: inline; filename="' . basename($fileUrl) . '"');

// Output the PDF content
echo $pdfContent;
?>

