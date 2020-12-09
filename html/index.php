<?php

/*
	Select Language
*/

// Include Base
include_once "common/base.php";
// Set Step
$step = 0;

// Reset Session
session_unset();

// Disable Back Button
$_SESSION["back_url" ] = $_SERVER["REQUEST_URI"];
$_SESSION["last_step"] = $step;

?>





<!DOCTYPE html>

<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="author" content="Ivan Gavrilov">
		<link rel="icon" href="img/favicon.png">

		<title>batterX traX</title>

		<link rel="stylesheet" href="css/dist/bundle.css?v=<?php echo $versionHash ?>">
		<link rel="stylesheet" href="css/common.css?v=<?php echo $versionHash ?>">
		<link rel="stylesheet" href="css/index.css?v=<?php echo $versionHash ?>">

	</head>

	<body>





		<div class="card elevate">

			<img class="logo" src="img/logo_trax.svg">

			<h1>Select Language</h1>

			<div class="row lang">
				<div id="lang_en" class="box col"><div class="lang-en"></div><span>English </span></div>
				<div id="lang_de" class="box col"><div class="lang-de"></div><span>Deutsch </span></div>
				<div id="lang_fr" class="box col"><div class="lang-fr"></div><span>Français</span></div>
				<div id="lang_cs" class="box col"><div class="lang-cs"></div><span>Čeština </span></div>
				<div id="lang_es" class="box col"><div class="lang-es"></div><span>Español </span></div>
			</div>
			
		</div>

		<span id="softwareVersion"><?php echo $softwareVersion; ?></span>





		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/index.js?v=<?php echo $versionHash ?>"></script>



		

	</body>

</html>
