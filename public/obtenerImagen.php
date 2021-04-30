<?php
	include_once "../app/config/configurar.php";
		$filename = $_GET['file'];
		$file = DOCUMENTOS_PRIVADOS."videos/".$filename;		
		$mime = mime_content_type($file);
		header('Content-type: '.$mime);
		readfile($file);
		
?>