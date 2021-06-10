$progress.trigger("step", 4);










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	Define Variables
*/

var systemApikey = apikey;
var systemSerial = "";

var isAlreadyRegistered = false;
var isSettingParameters = false;










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
    Helper Functions
*/

function disableBtnNext() { $("#btn_next").attr("disabled", true); }










/*
    Helper Functions
*/

function allFieldsCorrect() {
   
	// Return If Empty Fields
	if( $("#installation_date").val() == "" ||
		$("#bx_box           ").val() == ""
	) return false;

	// Return If Hybrid But Not Serialnumber
	if($("#bx_protocol").val() != "0" && ($("#bx_device").val() == "" || $("#bx_model").val() == "")) return false;

	// Return If Serialnumber But Not Hybrid
	if($("#bx_protocol").val() == "0" && ($("#bx_device").val() != "" || $("#bx_model").val() != "")) return false;

    return true;

}










/*
    Helper Functions
*/

function showSettingParametersError(errorStr) {
    isSettingParameters = false;
    $("#notif").removeClass("loading error success").addClass("error");
    $("#message").html(errorStr).css("color", "red");
    $("#btn_next").attr("disabled", false).unbind().on("click", () => { mainFormSubmit(); });
}










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	Device Serial Number OnChange
*/

$("#bx_device").on("change", () => {

	if($("#bx_device").val().trim() == "") return $("#bx_model").val("");

	$.post({
		url: "https://api.batterx.io/v3/install.php",
		data: {
			action: "get_device_model",
			serialnumber: $("#bx_device").val().trim()
		},
		error: () => { alert("E051. Please refresh the page!"); },
		success: (response) => {
			console.log(response);
			$("#bx_model").val(response);
		}
	});

});










/*
	Activate Submit Button
*/

setInterval(() => {

	// Return If Empty Fields
	if(!allFieldsCorrect()) return disableBtnNext();

	// Enable|Disable Button Next
	$("#btn_next").attr("disabled", isSettingParameters);

}, 1000);










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	Begin Process
*/

step1();










/*
	Check If Apikey Correct
*/

function step1() {

    if(!apikey || apikey.length != 40) return alert("E003. Please refresh the page!");

    step2();

}










/*
	Get Installation Info
*/

function step2() {

	$.post({
		url: "https://api.batterx.io/v3/install.php",
		data: {
			action: "get_installation_info",
			apikey: systemApikey
		},
		error: () => { alert("E004. Please refresh the page!"); },
		success: (json) => {

			console.log(json);

			if(!json) { step3(); return; }

			// Set System Info
			if(json.hasOwnProperty("system")) {
				if(json.system.hasOwnProperty("serialnumber")) {
					systemSerial = json.system.serialnumber;
				}
			}

			// Set Device Info
			if(json.hasOwnProperty("device")) {
				if(json.device.hasOwnProperty("serialnumber"))
					$("#bx_device").val(json.device.serialnumber);
				if(json.device.hasOwnProperty("model"))
					$("#bx_model").val(json.device.model);
				if(json.device.hasOwnProperty("solar_watt_peak"))
					$("#solar_wp").val(json.device.solar_watt_peak);
			}

			// Set Installation Date
			if(json.hasOwnProperty("installation_date"))
				$("#installation_date").val(json.installation_date);

			// Set Solar Info
			if(json.hasOwnProperty("solar_info"))
				$("#solar_info").val(json.solar_info);

			// Set Installer Memo
			if(json.hasOwnProperty("note"))
				$("#installer_memo").val(json.note);

			// Set Batteries Info
			if(json.hasOwnProperty("batteries")) {
				// Has Battery
				if(json.batteries.length > 0) {
					if(json.batteries[0].hasOwnProperty("capacity"))
						$("#battery_wh").val(json.batteries[0].capacity);
				}
				// No Battery
				else {
					$("#battery_wh").val("");
				}
			}

			isAlreadyRegistered = true;

			step3();

		}
	});

}










/*
	Set LiveX Serial-Number
*/

function step3() {

	$.post({
		url: "https://api.batterx.io/v3/install.php",
		data: {
			action: "get_box_serial",
			apikey: systemApikey
		},
		error: () => { alert("E005. Please refresh the page!"); },
		success: (response) => {

			console.log(response);

			var box_serial = response;
			
			if(!box_serial) return $("#errorBoxNotRegistered").modal("show");

			// Save LiveX Serial-Number to Session
			$.post({
				url: "cmd/session.php",
				data: { box_serial: box_serial },
				error: () => { alert("E006. Please refresh the page!"); },
				success: (response) => {
					console.log(response);
					if(response !== "1") return alert("E007. Please refresh the page!");
					$("#bx_box").val(box_serial);
					step4();
				}
			});
		}
	});

}










/*
    Load Other Parameters From Settings Table
*/

function step4() {
	
	$.get({
        url: "api.php?get=settings",
        error: () => { alert("E012. Please refresh the page!"); },
        success: (response) => {
            
            console.log(response);
            
            if(!response || typeof response != "object") return alert("E013. Please refresh the page!");

			// ConnectDevice Settings
			if(response.hasOwnProperty("ConnectDevice")) {
				var temp = response["ConnectDevice"]["0"];
				$("#bx_protocol").val(temp["mode"]);
			}

			// ConnectMeter Settings
			if(response.hasOwnProperty("ConnectMeter")) {
				var temp = response["ConnectMeter"]["0"];
				$("#meter_type").val(temp["mode"]);
				var list_meter_baudrate = [9600, 19200, 38400];
				$("#meter_baudrate").val(list_meter_baudrate.includes(temp["v1"]) ? temp["v1"] : 9600);
			}

			// ExtSol Meter
			if(response.hasOwnProperty("ModbusExtSolarDevice")) {
				var temp = response["ModbusExtSolarDevice"]["0"];
				if(parseInt(temp["mode"]) > 0) $("#meter_extsol").prop("checked", true);
			}

			// User Meters
			if(response.hasOwnProperty("UserMeter")) {
				var temp = response["UserMeter"];
				if(temp.hasOwnProperty("1") && parseInt(temp["1"]["mode"]) > 0) $("#meter_user1").prop("checked", true);
				if(temp.hasOwnProperty("2") && parseInt(temp["2"]["mode"]) > 0) $("#meter_user2").prop("checked", true);
				if(temp.hasOwnProperty("3") && parseInt(temp["3"]["mode"]) > 0) $("#meter_user3").prop("checked", true);
				if(temp.hasOwnProperty("4") && parseInt(temp["4"]["mode"]) > 0) $("#meter_user4").prop("checked", true);
			}

		}
	});

}










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	Main Form On-Submit
*/

$("#mainForm").on("submit", (e) => {
	e.preventDefault();
	mainFormSubmit();
});










/*
    Check All Fields
*/

function mainFormSubmit() {

	// Return If Empty Fields
	if(!allFieldsCorrect()) return;

	// Check Device S/N
	var canContinue = false;
	if($("#bx_device").val() == "" || $("#bx_model").val() == "") {
		canContinue = true;
	} else {
		$.post({
			url: "https://api.batterx.io/v3/install.php",
			async: false,
			data: {
				action       : "verify_device",
				serialnumber : $("#bx_device").val(),
				system       : $("#bx_box").val()
			},
			error: () => { alert("E014. Please refresh the page!"); },
			success: (response) => {
				console.log(response);
				if(response === "1") canContinue = true;
				else $("#errorInverterRegisteredWithOtherSystem").modal("show");
			}
		});
	}
	if(!canContinue) return;

	// Disable All Fields
	$(` #bx_box,
		#btnInstallerMemo,
		#installer_memo,
		#meter_type,
		#meter_baudrate,
		#meter_extsol,
		#meter_user1,
		#meter_user2,
		#meter_user3,
		#meter_user4,
		#bx_device,
		#bx_model,
		#bx_protocol,
		#solar_wp,
		#battery_wh,
		#solar_info
	`).attr("disabled", true);

	// Show Loading Screen
	isSettingParameters = true;
	disableBtnNext();
	$(".setting-progress").removeClass("d-none");

	// Scroll To Bottom
	$("html, body").scrollTop($(document).height());

	// Begin Setup
	setup1();

}










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	Begin Setup
*/

function setup1() {





	isSettingParameters = true;
	$("#notif").removeClass("loading error success").addClass("loading");
	$("#message").html(lang.trax_system_setup.msg_setting_parameters).css("color", "");





	// Set ConnectDevice

	var device_protocol = $("#bx_protocol").val();

	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=0 ConnectDevice&text2=" + device_protocol,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});





	// Set ConnectMeter
	
	var meter_type     = $("#meter_type    ").val();
	var meter_baudrate = $("#meter_baudrate").val();
	
	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=0 ConnectMeter&text2=" + meter_type,
		error: () => { alert("E044. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E045. Please refresh the page!"); }
	});

	$.get({
		url: "api.php?set=command&type=11&entity=21&text1=0 ConnectMeter&text2=" + meter_baudrate,
		error: () => { alert("E044. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E045. Please refresh the page!"); }
	});





	// Set ExtSol Meter

	var mode_extsol = $("#meter_extsol").is(":checked") ? "1" : "0";

	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=0 ModbusExtSolarDevice&text2=" + mode_extsol,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});





	// Set User Meters

	var mode_meter1 = $("#meter_user1").is(":checked") ? "1" : "0";
	var mode_meter2 = $("#meter_user2").is(":checked") ? "1" : "0";
	var mode_meter3 = $("#meter_user3").is(":checked") ? "1" : "0";
	var mode_meter4 = $("#meter_user4").is(":checked") ? "1" : "0";

	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=1 UserMeter&text2=" + mode_meter1,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});
	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=2 UserMeter&text2=" + mode_meter2,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});
	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=3 UserMeter&text2=" + mode_meter3,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});
	$.get({
		url: "api.php?set=command&type=11&entity=11&text1=4 UserMeter&text2=" + mode_meter4,
		error: () => { alert("E046. Please refresh the page!"); },
		success: (response) => { if(response != "1") return alert("E047. Please refresh the page!"); }
	});





	// Restart Program

	setTimeout(() => {
		$.get({
			url: "api.php?set=command&type=20897&entity=0&text1=&text2=",
			error: () => { alert("E046. Please refresh the page!"); },
			success: (response) => {
				if(response != "1") return alert("E047. Please refresh the page!");
				setup2();
			}
		});
	}, 10000);



	

}










/*
	Set Session Variables
*/

function setup2() {

	var tempData = {
		system_serial     : $("#bx_box").val(),
		device_serial     : $("#bx_device").val(),
		device_model      : $("#bx_model").val(),
		solar_wattpeak    : $("#solar_wp").val().trim() == "" ? "0" : $("#solar_wp").val(),
		solar_info        : $("#solar_info").val(),
		note              : $("#installer_memo").val(),
		installation_date : $("#installation_date").val(),
		battery_capacity  : $("#battery_wh").val().trim() == "" ? "0" : $("#battery_wh").val(),
		battery_type      : "other",
		battery_voltage   : "1" // TODO
	};

	console.log(tempData);

	$.post({
		url: "cmd/session.php",
		data: tempData,
		error: () => { alert("E048. Please refresh the page!"); },
		success: (response) => {
			console.log(response);
			if(response != "1") return alert("E049. Please refresh the page!");
			setTimeout(() => { systemTest(); }, 60000);
		}
	});

}










//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////










/*
	System Test
*/

var latestLogtime = null;

function systemTest() {

	$.get({
		url: "api.php?get=currentstate",
		error: () => { alert("E050. Please refresh the page!"); },
		success: (response) => {
			
			console.log(response);
			
			if(!response || typeof response != "object" || !response.hasOwnProperty("logtime")) {
				setTimeout(() => { systemTest(); }, 5000);
				return;
			}

			if(latestLogtime == null) latestLogtime = response.logtime;
			
			if(latestLogtime == response.logtime) {
				setTimeout(() => { systemTest(); }, 5000);
				return;
			}

			var device_working = false;
			var meter_working  = false;
			var extsol_working = false;
			var meter1_working = false;
			var meter2_working = false;
			var meter3_working = false;
			var meter4_working = false;

			if(response.hasOwnProperty( "353") && response[ "353"].hasOwnProperty(  "1")) device_working = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty(  "0")) meter_working  = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty(  "3")) extsol_working = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty("101")) meter1_working = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty("102")) meter2_working = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty("103")) meter3_working = true;
			if(response.hasOwnProperty("2913") && response["2913"].hasOwnProperty("104")) meter4_working = true;

			if(!device_working && $("#bx_model"    ).val() != ""   ) return showSettingParametersError("Communication Problem - Hybrid Inverter");
			if(!meter_working  && $("#meter_type"  ).val() != "0"  ) return showSettingParametersError("Communication Problem - Energy Meter (Modbus ID = 1)");
			if(!extsol_working && $("#meter_extsol").is(":checked")) return showSettingParametersError("Communication Problem - External Solar Meter (Modbus ID = 2)");
			if(!meter1_working && $("#meter_user1" ).is(":checked")) return showSettingParametersError("Communication Problem - User Meter 1 (Modbus ID = 101)");
			if(!meter2_working && $("#meter_user2" ).is(":checked")) return showSettingParametersError("Communication Problem - User Meter 2 (Modbus ID = 102)");
			if(!meter3_working && $("#meter_user3" ).is(":checked")) return showSettingParametersError("Communication Problem - User Meter 3 (Modbus ID = 103)");
			if(!meter4_working && $("#meter_user4" ).is(":checked")) return showSettingParametersError("Communication Problem - User Meter 4 (Modbus ID = 104)");

			systemTestWarnings();

		}
	});

}

function systemTestWarnings() {

	$.get({
		url: "api.php?get=warnings",
		error: () => { alert("E051. Please refresh the page!"); },
		success: (response) => {

			console.log(response);

			if(response.length != 1 || response[0].length != 2) return setTimeout(systemTest, 5000);

			var warnings = response[0][1];

			if(warnings.length > 0) {
				if(warnings.includes(18928)) return showSettingParametersError("Communication Problem - Energy Meter (Modbus ID = 1)");
				if(warnings.includes(18931)) return showSettingParametersError("Communication Problem - External Solar Meter (Modbus ID = 2)");
				if(warnings.includes(18938)) return showSettingParametersError("Communication Problem - User Meter 1 (Modbus ID = 101)");
				if(warnings.includes(18939)) return showSettingParametersError("Communication Problem - User Meter 2 (Modbus ID = 102)");
				if(warnings.includes(18940)) return showSettingParametersError("Communication Problem - User Meter 3 (Modbus ID = 103)");
				if(warnings.includes(18941)) return showSettingParametersError("Communication Problem - User Meter 4 (Modbus ID = 104)");
			} else {
				$(".setting-progress span").html(lang.trax_system_setup.msg_setting_success).css("color", "#28a745");
				$("#notif").removeClass("loading error success").addClass("success");
				setTimeout(function() { window.location.href = "installation_summary.php"; }, 2500);
			}

		}
	});

}
