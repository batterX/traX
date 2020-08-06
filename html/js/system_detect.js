$progress.trigger("step", 4);





step1();





// Get CurrentState (Verify if meter is working)

function step1() {

	$.get({
		url: "api.php?get=currentstate",
		error: () => { setTimeout(step1, 5000); },
		success: (json) => {
			console.log(json);
			if(!json || typeof json != "object" || !json.hasOwnProperty("logtime")) {
				setTimeout(step1, 5000);
				return;
			}
			var curtime   = moment.utc().subtract(1, "minute").format("YYYY-MM-DD hh:mm:ss");
			var isWorking = moment(json["logtime"]).isAfter(moment(curtime));
			if(!isWorking || !json.hasOwnProperty("2913") || !json["2913"].hasOwnProperty("0")) {
				setTimeout(step1, 5000);
				return;
			}
			// Continue Next Step
			step2();
		}
	});

}





// Check if LiveX registered in Cloud & Show Working Status

function step2() {

	$.post({
		url: "https://api.batterx.io/v3/install_trax.php",
		data: {
			action: "get_box_serial",
			apikey: apikey
		},
		error: () => { alert("E001. Please refresh the page!"); },
		success: (response) => {
			console.log(response);
			var box_serial = response;
			// Save Serial-Number to Session
			if(box_serial) {
				$.post({
					url: "cmd/session.php",
					data: { box_serial: box_serial },
					error: () => { alert("E002. Please refresh the page!"); },
					success: (response) => {
						console.log(response);
						if(response !== "1") return alert("E003. Please refresh the page!");
						$(".serialnumber b").text(box_serial);
						// Show Working
						$("#meterUnknown").addClass("d-none");
						$("#meterDetected").removeClass("d-none");
						// Enable Button
						$("#btn_next").attr("disabled", false);
					}
				});
			} else {
				// Show Not Registered
				$(".notif").removeClass("loading error success").addClass("error");
				$(".message").html(lang.system_detect.trax_not_registered).css("color", "red");
			}
		}
	});
}





// Button Next On-Click

$("#btn_next").on("click", () => { window.location.href = "installation_summary.php"; });
