<?php

/*
	System Setup
*/

// Include Base
include_once "common/base.php";
// Set Step
$step = 4;

// Disable Back Button
if(!isset($_SESSION["last_step"])) header("location: index.php");
if($_SESSION["last_step"] != $step && $_SESSION["last_step"] != $step - 1)
	header("location: " . (isset($_SESSION["back_url"]) ? $_SESSION["back_url"] : "index.php"));
$_SESSION["back_url" ] = $_SERVER["REQUEST_URI"];
$_SESSION["last_step"] = $step;

// Get Apikey
$output = shell_exec("cat /proc/cpuinfo");
$find = "Serial";
$pos = strpos($output, $find);
$serial = substr($output, $pos + 10, 16);
$apikey = sha1(strval($serial));
$_SESSION["box_apikey"] = $apikey;

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
		<link rel="stylesheet" href="css/system_setup.css?v=<?php echo $versionHash ?>">

	</head>

	<body>





		<!-- Progress Bar -->
		<div id="progress" class="shadow-lg">
			<div><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated"></div></div></div>
			<div><button id="btn_next" class="btn btn-success ripple" type="submit" form="mainForm" disabled><?php echo $lang["btn"]["continue"]; ?></button></div>
		</div>
		<!-- Progress Bar -->





		<div class="modal fade" id="errorBoxNotRegistered" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<div class="modal-body text-center">
						<span style="color: red"><b><?php echo $lang["trax_system_setup"]["msg_livex_not_registered"] ?></b></span>
						<div class="mt-3">
							<span class="d-block"><b>APIKEY</b></span>
							<input type="text" class="form-control form-control-outline text-center mt-2 px-2" style="font-size:95%" value="<?php echo $apikey ?>" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="errorInverterRegisteredWithOtherSystem" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<div class="modal-body text-center">
						<span style="color: red"><b><?php echo $lang["trax_system_setup"]["msg_inverter_registered_with_other_system"] ?></b></span>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalInstallerMemo" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-sm">
				<div class="modal-content">
					<h5 class="modal-header mb-0"><?php echo $lang["trax_system_setup"]["system_installer_memo"] ?></h5>
					<div class="modal-body"><textarea id="installer_memo" class="form-control form-control-outline"></textarea></div>
					<div class="modal-footer"><button type="button" class="btn btn-sm px-4 py-2 btn-success ripple" data-dismiss="modal"><b><?php echo $lang["btn"]["save"] ?></b></button></div>
				</div>
			</div>
		</div>





		<div class="container pb-5">
			<form id="mainForm" class="pb-4">

				<div class="row">

					<!-- batterX traX -->
					<div id="batterx" class="col-lg-6 pt-5">

						<h1 class="card-header bg-transparent border-0">batterX traX</h1>

						<div class="card elevate-1">
							<div class="card-body border-bottom pt-3">
								<label for="bx_box"><?php echo $lang["trax_system_setup"]["system_serialnumber_livex"] ?></label>
								<input id="bx_box" class="form-control form-control-outline" type="text" placeholder="<?php echo $lang["common"]["serialnumber"] ?>" value="" disabled required>
							</div>
							<div class="card-body p-2">
								<button id="btnInstallerMemo" type="button" class="btn btn-block ripple p-2" data-toggle="modal" data-target="#modalInstallerMemo"><small><b><?php echo $lang["trax_system_setup"]["system_installer_memo"] ?></b></small></button>
							</div>
						</div>

						<h1 class="card-header bg-transparent border-0 mt-5"><?php echo $lang["trax_system_setup"]["energy_meters"] ?> <small>(<?php echo $lang["trax_system_setup"]["optional"] ?>)</small></h1>

						<div class="card elevate-1">
							<div class="row p-0 m-0">
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom pt-3">
										<label for="meter_type"><?php echo $lang["trax_system_setup"]["type_of_energy_meters"] ?></label>
										<select id="meter_type" class="form-control form-control-outline">
											<option value="0"><?php echo $lang["trax_system_setup"]["none"] ?></option>
											<option value="1" selected>Eastron SDM630</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom pt-3">
										<label for="meter_baudrate"><?php echo $lang["trax_system_setup"]["baudrate"] ?></label>
										<select id="meter_baudrate" class="form-control form-control-outline">
											<option value="9600" selected>9600</option>
											<option value="19200">19200</option>
											<option value="38400">38400</option>
										</select>
									</div>
								</div>
								<div class="col-12 m-0 p-0">
									<div class="card-body border-top py-2">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="meter_extsol">
											<label class="custom-control-label my-1" for="meter_extsol"><?php echo $lang["trax_system_setup"]["extsol_meter"] ?> <span class="text-muted">(Modbus ID = 2)</span></label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="meter_user1">
											<label class="custom-control-label my-1" for="meter_user1"><?php echo $lang["trax_system_setup"]["user_meter"] ?> 1 <span class="text-muted">(Modbus ID = 101)</span></label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="meter_user2">
											<label class="custom-control-label my-1" for="meter_user2"><?php echo $lang["trax_system_setup"]["user_meter"] ?> 2 <span class="text-muted">(Modbus ID = 102)</span></label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="meter_user3">
											<label class="custom-control-label my-1" for="meter_user3"><?php echo $lang["trax_system_setup"]["user_meter"] ?> 3 <span class="text-muted">(Modbus ID = 103)</span></label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="meter_user4">
											<label class="custom-control-label my-1" for="meter_user4"><?php echo $lang["trax_system_setup"]["user_meter"] ?> 4 <span class="text-muted">(Modbus ID = 104)</span></label>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<!-- Hybrid Inverter -->
					<div id="device" class="col-lg-6 pt-5">

						<h1 class="card-header bg-transparent border-0"><?php echo $lang["trax_system_setup"]["hybrid_inverter"] ?> <small>(<?php echo $lang["trax_system_setup"]["optional"] ?>)</small></h1>

						<div class="card elevate-1">
							<div class="row p-0 m-0">
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom pt-3">
										<label for="bx_device"><?php echo $lang["common"]["serialnumber"] ?></label>
										<input id="bx_device" class="form-control form-control-outline" type="text" placeholder="<?php echo $lang["common"]["serialnumber"] ?>" value="">
									</div>
								</div>
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom pt-3">
										<label for="bx_model"><?php echo $lang["trax_system_setup"]["model"] ?></label>
										<input id="bx_model" class="form-control form-control-outline" type="text" placeholder="<?php echo $lang["trax_system_setup"]["model"] ?>" value="" disabled>
									</div>
								</div>
								<div class="col-12 m-0 p-0">
									<div class="card-body border-bottom pt-3">
										<label for="bx_protocol"><?php echo $lang["trax_system_setup"]["protocol"] ?></label>
										<select id="bx_protocol" class="form-control form-control-outline">
											<option value="0" selected><?php echo $lang["trax_system_setup"]["none"] ?></option>
											<option value="1">batterX h5/h10</option>
											<option value="2">batterX h5000/h5000+</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row p-0 m-0">
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom">
										<label for="solar_wp"><?php echo $lang["trax_system_setup"]["pv_system_size"] ?> (Wp)</label>
										<div class="input-group">
											<input id="solar_wp" class="form-control form-control-outline" type="number" step="1" min="0" placeholder="0">
											<div class="input-group-append"><span class="input-group-text">Wp</span></div>
										</div>
									</div>
								</div>
								<div class="col-md-6 m-0 p-0">
									<div class="card-body border-bottom">
										<label for="battery_wh"><?php echo $lang["trax_system_setup"]["battery_size"] ?> (Wh)</label>
										<div class="input-group">
											<input id="battery_wh" class="form-control form-control-outline" type="number" step="1" min="0" placeholder="0">
											<div class="input-group-append"><span class="input-group-text">Wh</span></div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body pt-3">
								<label for="solar_info"><?php echo $lang["trax_system_setup"]["pv_installation_info"] ?></label>
								<textarea id="solar_info" class="form-control form-control-outline" placeholder="Paneltyp: ...

MPPT 1
	String 1: ...
	String 2: ...
MPPT 2
	String 1: ...
	String 2: ..."></textarea>
							</div>
						</div>

					</div>

				</div>

				<div class="text-center">
					<div class="setting-progress pt-4 mt-5 d-none">
						<div class="d-flex align-items-center justify-content-center">
							<div id="notif" class="loading d-block"></div>
							<span id="message"><?php echo $lang["trax_system_setup"]["msg_setting_parameters"]; ?></span>
						</div>
					</div>
				</div>

				<input id="installation_date" type="hidden" value="<?php echo date("Y-m-d"); ?>">

			</form>

		</div>





		<script src="js/dist/bundle.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/dist/moment.js?v=<?php echo $versionHash ?>"></script>
		<script src="js/common.js?v=<?php echo $versionHash ?>"></script>
		<script>const lang = <?php echo json_encode($lang) ?>;</script>
		<script>const apikey = <?php echo json_encode($apikey) ?>;</script>
		<script src="js/system_setup.js?v=<?php echo $versionHash ?>"></script>



		

	</body>

</html>
