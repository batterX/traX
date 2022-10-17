<?php

/*
	Installation SUmamry
*/

// Include Base
include_once "common/base.php";
// Set Step
$step = 5;

// Disable Back Button
if(!isset($_SESSION["last_step"])) header("location: index.php");
if($_SESSION["last_step"] != $step && $_SESSION["last_step"] != $step - 1)
	header("location: " . (isset($_SESSION["back_url"]) ? $_SESSION["back_url"] : "index.php"));
$_SESSION["back_url" ] = $_SERVER["REQUEST_URI"];
$_SESSION["last_step"] = $step;

// Define Arrays
$arrayGender  = $lang["dict_gender"   ];
$arrayCountry = $lang["dict_countries"];

// Set Installation Date
$_SESSION["installation_date"] = date("Y-m-d");

$hasDevice  = (isset($_SESSION["device_serial"]) && $_SESSION["device_serial"] != "" && isset($_SESSION["device_model"]) && $_SESSION["device_model"]);
$hasBattery = (isset($_SESSION["battery_capacity"]) && $_SESSION["battery_capacity"] != "" && $_SESSION["battery_capacity"] != "0");
if(!$hasDevice) $hasBattery = false;

$_SESSION["has_device" ] = $hasDevice;
$_SESSION["has_battery"] = $hasBattery;

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
		<link rel="stylesheet" href="css/installation_summary.css?v=<?php echo $versionHash ?>">

	</head>

	<body>





		<!-- Progress Bar -->
		<div id="progress" class="shadow-lg">
			<div><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div></div></div>
		</div>
		<!-- Progress Bar -->





		<div id="summary" class="mt-5 mx-auto">

			<div class="head border box-margin">
				<div class="title br">
					<span><?php echo $lang["trax_summary"]["installation_summary"]; ?></span>
				</div>
				<div class="logo">
					<img src=" data:image/png;base64,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">
				</div>
			</div>

			<div class="installation-date border box-margin">
				<div class="box-row bb">
					<span class="br"><?php echo $lang["trax_summary"]["installation_date"]; ?></span>
					<span><?php echo $_SESSION["installation_date"]; ?></span>
				</div>
				<div class="box-row">
					<span class="br"><?php echo $lang["trax_summary"]["latest_maintenance"]; ?></span>
					<span><?php echo date("Y-m-d"); ?></span>
				</div>
			</div>
			
			<div class="installer-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["trax_summary"]["installer"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["name"]; ?></span>
					<span><?php echo $arrayGender[$_SESSION["installer_gender"]] . " " . $_SESSION["installer_firstname"] . " " . $_SESSION["installer_lastname"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["company"]; ?></span>
					<span><?php echo $_SESSION["installer_company"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["email"]; ?></span>
					<span><?php echo $_SESSION["installer_email"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["telephone"]; ?></span>
					<span><?php echo $_SESSION["installer_telephone"]; ?></span>
				</div>
				<?php if(!empty($_SESSION["note"])): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["trax_summary"]["installer_memo"]; ?></span>
						<span style="white-space: pre-wrap"><?php echo $_SESSION["note"]; ?></span>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="customer-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["trax_summary"]["customer"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["name"]; ?></span>
					<span><?php echo $arrayGender[$_SESSION["customer_gender"]] . " " . $_SESSION["customer_firstname"] . " " . $_SESSION["customer_lastname"]; ?></span>
				</div>
				<?php if(!empty($_SESSION["customer_company"])): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["common"]["company"]; ?></span>
						<span><?php echo $_SESSION["customer_company"]; ?></span>
					</div>
				<?php endif; ?>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["email"]; ?></span>
					<span><?php echo $_SESSION["customer_email"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["telephone"]; ?></span>
					<span><?php echo $_SESSION["customer_telephone"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["address"]; ?></span>
					<span><?php echo $_SESSION["customer_address"] . "<br>" . $_SESSION["customer_zipcode"] . " " . $_SESSION["customer_city"] . ", " . $arrayCountry[$_SESSION["customer_country"]]; ?></span>
				</div>
			</div>

			<div class="system-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["trax_summary"]["installation"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["trax_summary"]["installation_sn_livex"]; ?></span>
					<span><?php echo $_SESSION["box_serial"] . " (" . $_SESSION["software_version"] . ")"; ?></span>
				</div>
				<?php if($hasDevice): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["trax_summary"]["installation_sn_inverter"]; ?></span>
						<span><?php echo $_SESSION["device_serial"] . " (" . $_SESSION["device_model"] . ")"; ?></b></span>
					</div>
				<?php endif; ?>
				<?php if($hasBattery): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["trax_summary"]["installation_batteries"]; ?></span>
						<span><?php echo $_SESSION["battery_capacity"] . " Wh"; ?></span>
					</div>
				<?php endif; ?>
				<?php if($hasDevice): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["trax_summary"]["installation_solar_size"]; ?></span>
						<span><?php echo $_SESSION["solar_wattpeak"] . " Wp"; ?></span>
					</div>
				<?php endif; ?>
				<?php if($hasDevice && !empty($_SESSION["solar_info"])): ?>
					<div class="box-row bt">
						<span class="br"><?php echo $lang["trax_summary"]["installation_solar_info"]; ?></span>
						<span style="white-space: pre-wrap"><?php echo $_SESSION["solar_info"]; ?></span>
					</div>
				<?php endif; ?>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["common"]["address"]; ?></span>
					<span><?php echo $_SESSION["installation_address"] . "<br>" . $_SESSION["installation_zipcode"] . " " . $_SESSION["installation_city"] . ", " . $arrayCountry[$_SESSION["installation_country"]]; ?></span>
				</div>
			</div>

		</div>
		




		<div id="confirm" class="pt-5 pb-3 px-3 mx-auto">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="checkboxAccept">
				<label class="custom-control-label" for="checkboxAccept"><?php echo $lang["trax_summary"]["confirm_info"]; ?></label>
			</div>
		</div>

		



		<div id="btnFinish" class="px-3 mx-auto">
			<button id="btnFinishInstallation" class="btn btn-success ripple mb-3 mt-4 px-5 py-3"><?php echo $lang["trax_summary"]["finish_installation"]; ?></button>
		</div>





		<div id="successBox" class="container elevate-1 p-5 my-lg-5" style="display: none">

			<h1 class="text-success"><?php echo $lang["trax_summary"]["final_congratulations"]; ?></h1>

			<p class="mt-2rem"><?php echo $lang["trax_summary"]["final_text1"]; ?></p>

			<p><?php echo $lang["trax_summary"]["final_text2"]; ?></p>

			<p><?php echo $lang["trax_summary"]["final_text3"]; ?></p>

			<p class="mt-2rem"><?php echo $lang["trax_summary"]["final_text4"]; ?>: <br><a href="https://batterx.app" target="_blank">batterx.app</a></p>

			<p class="mt-2rem"><?php echo $lang["trax_summary"]["final_text5"]; ?></p>

			<button id="btnDownload" class="btn btn-sm btn-success ripple py-2 px-4"><?php echo $lang["trax_summary"]["final_download_pdf"]; ?></button>

			<p class="mt-2rem"><?php echo $lang["trax_summary"]["final_text6"]; ?></p>

			<div class="d-flex align-items-center">
				<button id="btnReboot" class="btn btn-sm btn-primary ripple py-2 px-4"><?php echo $lang["trax_summary"]["final_reboot_livex"]; ?></button>
				<div class="notif ml-3"></div>
			</div>

		</div>





		<input id="lang" type="hidden" value="<?php echo $_SESSION["lang"]; ?>">

		



		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/jspdf.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/html2canvas.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script>const lang = <?php echo json_encode($lang); ?>;</script>
		<script>const dataObj = <?php echo json_encode($_SESSION); ?>;</script>
		<script src="js/installation_summary.js?v=<?php echo $versionHash ?>"></script>



	</body>

</html>
