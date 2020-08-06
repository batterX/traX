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
					<span><?php echo $lang["summary"]["installation_summary"]; ?></span>
				</div>
				<div class="logo">
					<img src="img/batterx_logo.png">
				</div>
			</div>

			<div class="installation-date border box-margin">
				<div class="box-row">
					<span class="br"><?php echo $lang["summary"]["installation_date"]; ?></span>
					<span><?php echo $_SESSION["installation_date"]; ?></span>
				</div>
			</div>

			<div class="installer-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["summary"]["installer"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["name"]; ?></span>
					<span><?php echo $arrayGender[$_SESSION["installer_gender"]] . " " . $_SESSION["installer_firstname"] . " " . $_SESSION["installer_lastname"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["company"]; ?></span>
					<span><?php echo $_SESSION["installer_company"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["email"]; ?></span>
					<span><?php echo $_SESSION["installer_email"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["telephone"]; ?></span>
					<span><?php echo $_SESSION["installer_telephone"]; ?></span>
				</div>
			</div>
			
			<div class="customer-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["summary"]["customer"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["name"]; ?></span>
					<span><?php echo $arrayGender[$_SESSION["customer_gender"]] . " " . $_SESSION["customer_firstname"] . " " . $_SESSION["customer_lastname"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["email"]; ?></span>
					<span><?php echo $_SESSION["customer_email"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["telephone"]; ?></span>
					<span><?php echo $_SESSION["customer_telephone"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["address"]; ?></span>
					<span><?php echo $_SESSION["customer_address"] . "<br>" . $_SESSION["customer_zipcode"] . " " . $_SESSION["customer_city"] . ", " . $arrayCountry[$_SESSION["customer_country"]]; ?></span>
				</div>
			</div>

			<div class="system-info border box-margin">
				<div class="box-head">
					<span><?php echo $lang["summary"]["installation"]; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["serialnumber"]; ?></span>
					<span><?php echo $_SESSION["box_serial"] . " (batterX traX)"; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $lang["summary"]["address"]; ?></span>
					<span><?php echo $_SESSION["installation_address"] . "<br>" . $_SESSION["installation_zipcode"] . " " . $_SESSION["installation_city"] . ", " . $arrayCountry[$_SESSION["installation_country"]]; ?></span>
				</div>
			</div>

		</div>
		




		<div id="confirm" class="pt-5 pb-3 px-3 mx-auto">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="checkboxAccept">
				<label class="custom-control-label" for="checkboxAccept"><?php echo $lang["summary"]["confirm_box"]; ?></label>
			</div>
		</div>

		



		<div id="btnFinish" class="px-3 mx-auto">
			<button id="btnFinishInstallation" class="btn btn-success ripple mb-3 mt-4 px-5 py-3"><?php echo $lang["summary"]["finish_installation"]; ?></button>
		</div>





		<div id="successBox" class="container elevate-1 p-5 my-lg-5" style="display: none">

			<h1 class="text-success"><?php echo $lang["summary"]["final_congratulations"]; ?></h1>

			<p class="mt-2rem"><?php echo $lang["summary"]["final_p1"]; ?></p>

			<p><?php echo $lang["summary"]["final_p2"]; ?></p>

			<p><?php echo $lang["summary"]["final_p3"]; ?></p>

			<p class="mb-2 mt-2rem"><?php echo $lang["summary"]["final_p6"]; ?>: <br><a href="https://my.batterx.io" target="_blank">my.batterx.io</a></p>

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
