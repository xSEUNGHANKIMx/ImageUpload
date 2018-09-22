<?php

$upload_dir = './upload';
$output_dir = './output';
$allowed_ext = array('jpg','jpeg','png','gif');
$error = $_FILES['image']['error'];
$filename = $_FILES['image']['name'];
$ext = strtolower(array_pop(explode('.', $filename)));

if (!file_exists("$upload_dir")) {
	$old1 = umask(0);
	mkdir($upload_dir, 0777);
	umask($old1);
}

if (!file_exists("$output_dir")) {
	$old2 = umask(0);
	mkdir($output_dir, 0777);
	umask($old2);
}

if( $error != UPLOAD_ERR_OK ) {
	switch( $error ) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			echo "File is too big. ($error)";
			break;
		case UPLOAD_ERR_NO_FILE:
			echo "No file is attached. ($error)";
			break;
		default:
			echo "File upload is failed. ($error)";
	}
	unlink($_FILES['image']['tmp_name']);
	exit;
}
 
if( !in_array($ext, $allowed_ext) ) {
	echo "It is not allowed file extension.";
	unlink($_FILES['image']['tmp_name']);
	exit;
}
 
move_uploaded_file( $_FILES['image']['tmp_name'], "$upload_dir/$filename");

$command = "python process_image.py '$filename'";
shell_exec($command);


echo "<h2>Processing Finished!</h2> <br>
	<h3>[Original Image]</h3>
	<img src='$upload_dir/$filename' alt='your image' height='40%'/> <br><br><br>
	<h3>[Result Image]</h3>
	<img src='$output_dir/$filename' alt='output image' height='40%'/>"
?>
