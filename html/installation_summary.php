<?php

include_once "common/base.php";
$step = 5;

// Check Step
if(!isset($_SESSION['last_step'])) header("location: index.php");
if($_SESSION['last_step'] != $step && $_SESSION['last_step'] != $step - 1)
	header('location: ' . (isset($_SESSION['back_url']) ? $_SESSION['back_url'] : "index.php"));
$_SESSION['back_url']  = $_SERVER['REQUEST_URI'];
$_SESSION['last_step'] = $step;

// Value Arrays
$arrayGender = [
	'0' => $strings['gender_male'],
	'1' => $strings['gender_female']
];
$arrayCountry = [
	'at' => $strings['c_at'],
	'by' => $strings['c_by'],
	'be' => $strings['c_be'],
	'cy' => $strings['c_cy'],
	'cz' => $strings['c_cz'],
	'dk' => $strings['c_dk'],
	'ee' => $strings['c_ee'],
	'fi' => $strings['c_fi'],
	'fr' => $strings['c_fr'],
	'ge' => $strings['c_ge'],
	'de' => $strings['c_de'],
	'gr' => $strings['c_gr'],
	'hu' => $strings['c_hu'],
	'is' => $strings['c_is'],
	'ie' => $strings['c_ie'],
	'it' => $strings['c_it'],
	'lv' => $strings['c_lv'],
	'lt' => $strings['c_lt'],
	'lu' => $strings['c_lu'],
	'mt' => $strings['c_mt'],
	'md' => $strings['c_md'],
	'nl' => $strings['c_nl'],
	'no' => $strings['c_no'],
	'pl' => $strings['c_pl'],
	'pt' => $strings['c_pt'],
	'ro' => $strings['c_ro'],
	'ru' => $strings['c_ru'],
	'sk' => $strings['c_sk'],
	'si' => $strings['c_si'],
	'es' => $strings['c_es'],
	'se' => $strings['c_se'],
	'ch' => $strings['c_ch'],
	'tr' => $strings['c_tr'],
	'ua' => $strings['c_ua'],
	'gb' => $strings['c_gb'],
	'sn' => $strings['c_sn'],
	'ci' => $strings['c_ci'],
	'gh' => $strings['c_gh'],
	'ng' => $strings['c_ng'],
	'tg' => $strings['c_tg'],
	'cd' => $strings['c_cd'],
	'ug' => $strings['c_ug'],
	'ke' => $strings['c_ke'],
	'za' => $strings['c_za'],
	're' => $strings['c_re']
];

$_SESSION['installation_date'] = date('Y-m-d');

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
		<link rel="stylesheet" href="css/installation_summary.css?v=<?php echo $versionHash ?>">

	</head>



	<body>



		<div id="progress" class="shadow-lg">
			<div><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div></div></div>
		</div>



		<div id="summary" class="mt-5 mx-auto">

			<div class="head border box-margin">
				<div class="title br">
					<span><?php echo $strings['summary_installation_summary']; ?></span>
				</div>
				<div class="logo">
					<img src="img/batterx_logo.png">
				</div>
			</div>

			<div class="installation-date border box-margin">
				<div class="box-row">
					<span class="br"><?php echo $strings['summary_installation_date']; ?></span>
					<span><?php echo $_SESSION['installation_date']; ?></span>
				</div>
			</div>
			
			<div class="installer-info border box-margin">
				<div class="box-head">
					<span><?php echo $strings['summary_installer']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_name']; ?></span>
					<span><?php echo $arrayGender[$_SESSION['installer_gender']] . " " . $_SESSION['installer_firstname'] . " " . $_SESSION['installer_lastname']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_company']; ?></span>
					<span><?php echo $_SESSION['installer_company']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_email']; ?></span>
					<span><?php echo $_SESSION['installer_email']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_telephone']; ?></span>
					<span><?php echo $_SESSION['installer_telephone']; ?></span>
				</div>
			</div>
			
			<div class="customer-info border box-margin">
				<div class="box-head">
					<span><?php echo $strings['summary_customer']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_name']; ?></span>
					<span><?php echo $arrayGender[$_SESSION['customer_gender']] . " " . $_SESSION['customer_firstname'] . " " . $_SESSION['customer_lastname']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_email']; ?></span>
					<span><?php echo $_SESSION['customer_email']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_telephone']; ?></span>
					<span><?php echo $_SESSION['customer_telephone']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_customer_address']; ?></span>
					<span><?php echo $_SESSION['customer_address'] . "<br>" . $_SESSION['customer_zipcode'] . " " . $_SESSION['customer_city'] . ", " . $arrayCountry[$_SESSION['customer_country']]; ?></span>
				</div>
			</div>

			<!--                      -->
			<!-- Installation Details -->
			<!--                      -->

			<div class="system-info border box-margin">
				<div class="box-head">
					<span><?php echo $strings['summary_installation']; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_serialnumber']; ?></span>
					<span><?php echo $_SESSION['box_serial'] . " (batterX traX)"; ?></span>
				</div>
				<div class="box-row bt">
					<span class="br"><?php echo $strings['summary_installation_address']; ?></span>
					<span><?php echo $_SESSION['installation_address'] . "<br>" . $_SESSION['installation_zipcode'] . " " . $_SESSION['installation_city'] . ", " . $arrayCountry[$_SESSION['installation_country']]; ?></span>
				</div>
			</div>

		</div>
		


		<div id="confirm" class="pt-5 pb-3 mx-auto">
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="checkboxAccept">
				<label class="custom-control-label" for="checkboxAccept"><?php echo $strings['summary_confirm_box']; ?></label>
			</div>
		</div>

		

		<div id="btnFinish" class="text-left mx-auto">
			<button id="btnFinishInstallation" class="btn btn-success ripple mb-3 mt-4 px-5 py-3"><?php echo $strings['summary_finish_installation']; ?></button>
		</div>



		<div id="successBox" class="container" style="display: none">

			<h1><b class="text-success"><?php echo $strings['final_congratulations']; ?></b></h1>

			<p><?php echo $strings['final_p1']; ?></p>

			<p><?php echo $strings['final_p2']; ?></p>

			<p><?php echo $strings['final_p3']; ?></p>

			<p class="mt-5"><?php echo $strings['final_p6']; ?>: <br><a href="https://my.batterx.io" target="_blank" style="color: var(--color-link) !important;">my.batterx.io</a></p>

		</div>

		<input id="lang" type="hidden" value="<?php echo $_SESSION['lang']; ?>">



		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/jspdf.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/html2canvas.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script>const lang = <?php echo json_encode($strings); ?>;</script>
		<script>const dataObj = <?php echo json_encode($_SESSION); ?>;</script>
		<script src="js/installation_summary.js?v=<?php echo $versionHash ?>"></script>



	</body>

</html>
