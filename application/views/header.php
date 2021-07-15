<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<title><?= $header['title'] ?></title>
	<link rel="stylesheet" href="<?= base_url().'/assets/css/main_style_min.css' ?>">
	<?php if(isset($scriptData)){ AN_header_script($scriptData);}else{ AN_header_script(); } ?>
</head>
<body>