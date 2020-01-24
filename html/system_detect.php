<?php

include_once "common/base.php";
$step = 4;

// Check Step
if(!isset($_SESSION['last_step'])) header("location: index.php");
if($_SESSION['last_step'] != $step && $_SESSION['last_step'] != $step - 1)
	header('location: ' . (isset($_SESSION['back_url']) ? $_SESSION['back_url'] : "index.php"));
$_SESSION['back_url' ] = $_SERVER['REQUEST_URI'];
$_SESSION['last_step'] = $step;

$installationCountry = isset($_SESSION['installation_country']) ? $_SESSION['installation_country'] : "de";

?>



<!DOCTYPE html>

<html>



	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="author" content="Ivan Gavrilov">
		<link rel="icon" href="img/favicon.png">

		<title>batterX liveX</title>

		<link rel="stylesheet" href="css/dist/bundle.css?v=<?php echo $versionHash ?>">
		<link rel="stylesheet" href="css/common.css?v=<?php echo $versionHash ?>">
		<link rel="stylesheet" href="css/system_detect.css?v=<?php echo $versionHash ?>">

	</head>



	<body>



		<div id="progress" class="shadow-lg">
			<div><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div></div></div>
			<div><button id="btn_next" class="btn btn-success ripple" disabled><?php echo $strings['continue']; ?></button></div>
		</div>



		<div class="container">

			<div id="meterUnknown">
				<h1><?php echo $strings['energy_meter_not_working']; ?></h1>
				<div class="d-flex align-items-center justify-content-center">
					<div class="notif loading"></div>
					<span class="message"><?php echo $strings['please_connect_energy_meter']; ?></span>
				</div>
			</div>

			<div id="meterDetected">
				<h1>batter<span>X</span> <small><b>traX</b></small></h1>
				<img src="img/device_trax.png">
				<span class="serialnumber">S/N: <b></b></span>
				<div class="text-center"><div class="status-success success"></div></div>
			</div>

		</div>



		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/moment.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script>const lang = <?php echo json_encode($strings); ?>;</script>
		<script>const installationCountry = <?php echo json_encode($installationCountry); ?>;</script>
		<script src="js/system_detect.js?v=<?php echo $versionHash ?>"></script>



	</body>

</html>
