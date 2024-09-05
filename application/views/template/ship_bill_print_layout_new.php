<!DOCTYPE html>
<html>
<head>
	<title>Bill Invoice</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav-icon.png'); ?>">
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
	<style type="text/css">
        @page {
		  size: A4 portrait;
		}
		@page {
		  size: A4 portrait;
		}

		@page :first {
			margin-top: 35pt;
		}
		@page :left {
			margin-right: 30pt;
		}
		@page :right {
			margin-left: 30pt;
		}
		  /* Centering the image */
        img {
            display: block;
            margin: 0 auto; /* This centers the image horizontally */
        }
		</style>
</head>
<body onload="window.print()">
<!-- onload="window.print()" -->
<?php
$file_path = base_url('uploads/photo/') . $invoice->invoice_file; // Path to the file
$file_extension = pathinfo($file_path, PATHINFO_EXTENSION); // Get the file extension

if ($file_extension === 'pdf') {
    // If the file is a PDF, embed it using the <embed> tag
    echo '<div style="width: 100%; height: 100vh;"><embed src="' . $file_path . '" type="application/pdf" width="100%" height="100%" style="height: 100vh;"></div>';
} elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
    // If the file is an image, display it using the <img> tag
    echo '<img src="' . $file_path . '" style="max-width: 100%; max-height: 100vh;">';
} else {
    // For other file types, display a message indicating that the file format is not supported
    echo '<p>File format not supported for direct display. Please download the file.</p>';
}
?>

</body>
</html>
