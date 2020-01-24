$progress.trigger('step', 4);





step1();










// Get CurrentState -> Verify if System is Working
function step1()
{
	$.get({
		url: 'api.php?get=currentstate',
		error: () => { setTimeout(step1, 5000); },
		success: (json) => {
			console.log(json);
			if(!json || typeof json != 'object' || !json.hasOwnProperty('logtime')) {
				setTimeout(step1, 5000);
				return;
			}
			var curtime   = moment.utc().subtract(1, 'minute').format("YYYY-MM-DD hh:mm:ss");
			var isWorking = moment(json['logtime']).isAfter(moment(curtime));
			if(!isWorking || !json.hasOwnProperty('273') || !json['273'].hasOwnProperty('1') || json['273']['0'] < 10) {
				setTimeout(step1, 5000);
				return;
			}
			// Continue Next Step
			step2(json);
		}
	});
}





// Get LiveX Apikey
function step2(json)
{
	$.get({
		url: 'cmd/apikey.php',
		error: () => { alert("E001. Please refresh the page!"); },
		success: (json) => {
			console.log(json);
			if(!json || json.length != 40) return alert("E002. Please refresh the page!");
			// Continue Next Step
			step3(json.toString().trim());
		}
	});
}





// Check if LiveX registered in Cloud & Show Working Status
function step3(json)
{
	var systemApikey = json;

	$.post({
		url: "https://api.batterx.io/v2/commissioning_v2.php",
		data: {
			action: "retrieve_box_serial",
			apikey: systemApikey
		},
		error: () => { alert("E004. Please refresh the page!"); },
		success: (response) => {
			console.log(response);
			var box_serial = response;
			// Save Serial-Number to Session
			$.post({
				url: "cmd/session.php",
				data: { box_serial: box_serial },
				error: () => { alert("E005. Please refresh the page!"); },
				success: (response) => {
					console.log(response);
					if(response !== '1') return alert("E006. Please refresh the page!");
					$('.serialnumber b').text(box_serial);
					// Show Working
					$('#meterUnknown').hide();
					$('#meterDetected').show();
					// Continue Next Step
					step4();
				}
			});
		}
	});
}





// Show Success Status & Enable Button
function step4()
{
	$('.status-loading').removeClass('loading error success').addClass('success');
	$('#btn_next').attr('disabled', false);
	setTimeout(() => { window.location.href = "installation_summary.php"; }, 5000);
}










// Button Next On-Click
$('#btn_next').on('click', () => { window.location.href = "installation_summary.php"; });
