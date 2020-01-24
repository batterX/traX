<?php

include_once "common/base.php";
$step = 3;

// Check Step
if(!isset($_SESSION['last_step'])) header("location: index.php");
if($_SESSION['last_step'] != $step && $_SESSION['last_step'] != $step - 1)
	header('location: ' . (isset($_SESSION['back_url']) ? $_SESSION['back_url'] : "index.php"));
$_SESSION['back_url' ] = $_SERVER['REQUEST_URI'];
$_SESSION['last_step'] = $step;

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
		<link rel="stylesheet" href="css/customer_info.css?v=<?php echo $versionHash ?>">

	</head>



	<body>



		<div id="progress" class="shadow-lg">
			<div><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div></div></div>
			<div><button id="btn_next" class="btn btn-success ripple" type="submit" form="mainForm" disabled><?php echo $strings['continue']; ?></button></div>
		</div>



		<div class="container">

			<form id="mainForm">



				<h1 class="customer-informations"><?php echo $strings['customer_informations']; ?></h1>



				<div id="customerInformations" class="row">

					<div class="col-md-2 input-padding">
						<select class="gender custom-select custom-select-outline" required>
							<option value="0"><?php echo $strings['gender_male'  ]; ?></option>
							<option value="1"><?php echo $strings['gender_female']; ?></option>
						</select>
					</div>
					<div class="col-md-5 input-padding">
						<input class="first-name form-control form-control-outline" type="text" placeholder="<?php echo $strings['first_name']; ?>" required>
					</div>
					<div class="col-md-5 input-padding">
						<input class="last-name form-control form-control-outline" type="text" placeholder="<?php echo $strings['last_name']; ?>" required>
					</div>

					<div class="col-md-2"></div>
					<div class="col-md-5 input-padding">
						<input class="email form-control form-control-outline" type="email" placeholder="<?php echo $strings['email']; ?>" required>
					</div>
					<div class="col-md-5 input-padding">
						<input class="telephone form-control form-control-outline" type="text" placeholder="<?php echo $strings['telephone']; ?>" required>
					</div>

					<div class="w-100 p-3"></div>

					<div class="col-md-4 input-padding">
						<select class="location-country custom-select custom-select-outline" required>
							<option value="de"><?php echo $strings['c_de'] ?></option>
							<option value="at"><?php echo $strings['c_at'] ?></option>
							<option value="be"><?php echo $strings['c_be'] ?></option>
							<optgroup label="<?php echo $strings['europe'] ?>">
								<option value="at"><?php echo $strings['c_at'] ?></option>
								<option value="by"><?php echo $strings['c_by'] ?></option>
								<option value="be"><?php echo $strings['c_be'] ?></option>
								<option value="cy"><?php echo $strings['c_cy'] ?></option>
								<option value="cz"><?php echo $strings['c_cz'] ?></option>
								<option value="dk"><?php echo $strings['c_dk'] ?></option>
								<option value="ee"><?php echo $strings['c_ee'] ?></option>
								<option value="fi"><?php echo $strings['c_fi'] ?></option>
								<option value="fr"><?php echo $strings['c_fr'] ?></option>
								<option value="ge"><?php echo $strings['c_ge'] ?></option>
								<option value="de"><?php echo $strings['c_de'] ?></option>
								<option value="gr"><?php echo $strings['c_gr'] ?></option>
								<option value="hu"><?php echo $strings['c_hu'] ?></option>
								<option value="is"><?php echo $strings['c_is'] ?></option>
								<option value="ie"><?php echo $strings['c_ie'] ?></option>
								<option value="it"><?php echo $strings['c_it'] ?></option>
								<option value="lv"><?php echo $strings['c_lv'] ?></option>
								<option value="lt"><?php echo $strings['c_lt'] ?></option>
								<option value="lu"><?php echo $strings['c_lu'] ?></option>
								<option value="mt"><?php echo $strings['c_mt'] ?></option>
								<option value="md"><?php echo $strings['c_md'] ?></option>
								<option value="nl"><?php echo $strings['c_nl'] ?></option>
								<option value="no"><?php echo $strings['c_no'] ?></option>
								<option value="pl"><?php echo $strings['c_pl'] ?></option>
								<option value="pt"><?php echo $strings['c_pt'] ?></option>
								<option value="ro"><?php echo $strings['c_ro'] ?></option>
								<option value="ru"><?php echo $strings['c_ru'] ?></option>
								<option value="sk"><?php echo $strings['c_sk'] ?></option>
								<option value="si"><?php echo $strings['c_si'] ?></option>
								<option value="es"><?php echo $strings['c_es'] ?></option>
								<option value="se"><?php echo $strings['c_se'] ?></option>
								<option value="ch"><?php echo $strings['c_ch'] ?></option>
								<option value="tr"><?php echo $strings['c_tr'] ?></option>
								<option value="ua"><?php echo $strings['c_ua'] ?></option>
								<option value="gb"><?php echo $strings['c_gb'] ?></option>
							</optgroup>
							<optgroup label="<?php echo $strings['africa'] ?>">
								<option value="sn"><?php echo $strings['c_sn'] ?></option>
								<option value="ci"><?php echo $strings['c_ci'] ?></option>
								<option value="gh"><?php echo $strings['c_gh'] ?></option>
								<option value="ng"><?php echo $strings['c_ng'] ?></option>
								<option value="tg"><?php echo $strings['c_tg'] ?></option>
								<option value="cd"><?php echo $strings['c_cd'] ?></option>
								<option value="ug"><?php echo $strings['c_ug'] ?></option>
								<option value="ke"><?php echo $strings['c_ke'] ?></option>
								<option value="za"><?php echo $strings['c_za'] ?></option>
								<option value="re"><?php echo $strings['c_re'] ?></option>
							</optgroup>
						</select>
					</div>
					<div class="col-md-4 input-padding">
						<input class="location-city form-control form-control-outline" type="text" placeholder="<?php echo $strings['city']; ?>" required>
					</div>
					<div class="col-md-4 input-padding">
						<input class="location-zip form-control form-control-outline" type="text" placeholder="<?php echo $strings['zip_code']; ?>" required>
					</div>

					<div class="col-md-12 input-padding">
						<input class="location-address form-control form-control-outline" type="text" placeholder="<?php echo $strings['address']; ?>" required>
					</div>

				</div>



				<h1 class="installation-address"><?php echo $strings['installation_address']; ?></h1>



				<div class="custom-control custom-checkbox mx-3 my-3">
					<input type="checkbox" class="custom-control-input" id="sameAddress">
					<label class="custom-control-label" for="sameAddress"><?php echo $strings['same_as_customer_address']; ?></label>
				</div>

				<div id="installationAddress" class="row">

					<div class="col-md-4 input-padding">
						<select class="location-country custom-select custom-select-outline">
							<option value="de"><?php echo $strings['c_de'] ?></option>
							<option value="at"><?php echo $strings['c_at'] ?></option>
							<option value="be"><?php echo $strings['c_be'] ?></option>
							<optgroup label="<?php echo $strings['europe'] ?>">
								<option value="at"><?php echo $strings['c_at'] ?></option>
								<option value="by"><?php echo $strings['c_by'] ?></option>
								<option value="be"><?php echo $strings['c_be'] ?></option>
								<option value="cy"><?php echo $strings['c_cy'] ?></option>
								<option value="cz"><?php echo $strings['c_cz'] ?></option>
								<option value="dk"><?php echo $strings['c_dk'] ?></option>
								<option value="ee"><?php echo $strings['c_ee'] ?></option>
								<option value="fi"><?php echo $strings['c_fi'] ?></option>
								<option value="fr"><?php echo $strings['c_fr'] ?></option>
								<option value="ge"><?php echo $strings['c_ge'] ?></option>
								<option value="de"><?php echo $strings['c_de'] ?></option>
								<option value="gr"><?php echo $strings['c_gr'] ?></option>
								<option value="hu"><?php echo $strings['c_hu'] ?></option>
								<option value="is"><?php echo $strings['c_is'] ?></option>
								<option value="ie"><?php echo $strings['c_ie'] ?></option>
								<option value="it"><?php echo $strings['c_it'] ?></option>
								<option value="lv"><?php echo $strings['c_lv'] ?></option>
								<option value="lt"><?php echo $strings['c_lt'] ?></option>
								<option value="lu"><?php echo $strings['c_lu'] ?></option>
								<option value="mt"><?php echo $strings['c_mt'] ?></option>
								<option value="md"><?php echo $strings['c_md'] ?></option>
								<option value="nl"><?php echo $strings['c_nl'] ?></option>
								<option value="no"><?php echo $strings['c_no'] ?></option>
								<option value="pl"><?php echo $strings['c_pl'] ?></option>
								<option value="pt"><?php echo $strings['c_pt'] ?></option>
								<option value="ro"><?php echo $strings['c_ro'] ?></option>
								<option value="ru"><?php echo $strings['c_ru'] ?></option>
								<option value="sk"><?php echo $strings['c_sk'] ?></option>
								<option value="si"><?php echo $strings['c_si'] ?></option>
								<option value="es"><?php echo $strings['c_es'] ?></option>
								<option value="se"><?php echo $strings['c_se'] ?></option>
								<option value="ch"><?php echo $strings['c_ch'] ?></option>
								<option value="tr"><?php echo $strings['c_tr'] ?></option>
								<option value="ua"><?php echo $strings['c_ua'] ?></option>
								<option value="gb"><?php echo $strings['c_gb'] ?></option>
							</optgroup>
							<optgroup label="<?php echo $strings['africa'] ?>">
								<option value="sn"><?php echo $strings['c_sn'] ?></option>
								<option value="ci"><?php echo $strings['c_ci'] ?></option>
								<option value="gh"><?php echo $strings['c_gh'] ?></option>
								<option value="ng"><?php echo $strings['c_ng'] ?></option>
								<option value="tg"><?php echo $strings['c_tg'] ?></option>
								<option value="cd"><?php echo $strings['c_cd'] ?></option>
								<option value="ug"><?php echo $strings['c_ug'] ?></option>
								<option value="ke"><?php echo $strings['c_ke'] ?></option>
								<option value="za"><?php echo $strings['c_za'] ?></option>
								<option value="re"><?php echo $strings['c_re'] ?></option>
							</optgroup>
						</select>
					</div>
					<div class="col-md-4 input-padding">
						<input class="location-city form-control form-control-outline" type="text" placeholder="<?php echo $strings['city']; ?>" required>
					</div>
					<div class="col-md-4 input-padding">
						<input class="location-zip form-control form-control-outline" type="text" placeholder="<?php echo $strings['zip_code']; ?>" required>
					</div>
					
					<div class="col-md-12 input-padding">
						<input class="location-address form-control form-control-outline" type="text" placeholder="<?php echo $strings['address']; ?>" required>
					</div>

				</div>



			</form>

		</div>



		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script>const lang = <?php echo json_encode($strings); ?>;</script>
		<script>const installerEmail = <?php echo json_encode($_SESSION['installer_email']); ?>;</script>
		<script src="js/customer_info.js?v=<?php echo $versionHash ?>"></script>



	</body>

</html>
