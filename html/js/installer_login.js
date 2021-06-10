$progress.trigger("step", 2);





// Get Latest Version Number
var canContinue = false;
$.get({
	url: "https://raw.githubusercontent.com/batterX/traX/master/version.txt",
	dataType: "text",
	cache: false,
	error: () => {
		canContinue = true;
		enableLogin();
	},
	success: (versionNum) => {
		if(softwareVersion != versionNum) {
			window.location.href = ".";
		} else {
			canContinue = true;
			enableLogin();
		}
	}
});





var isLoggedIn = false;

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function enableLogin() {
	var e = $("#email   ").val().trim();
	var p = $("#password").val().trim();
	$("#btn_next").attr("disabled", e == "" || p == "" || !validateEmail(e) || !canContinue);
	isLoggedIn = false;
}

$(document).ready(() => { enableLogin(); });
$("#email, #password").on("input change", enableLogin);





$("#loginForm").on("submit", (e) => {

	e.preventDefault();

	if(isLoggedIn) {
		window.location.href = "customer_info.php";
		return;
	}

	// Verify Email + Password & Return Installer Information

	var email = $("#email   ").val().trim();
	var pass  = $("#password").val();

	if(email != "" && pass != "" && validateEmail(email)) {
		$.post({
			url: "https://api.batterx.io/v3/install.php",
			data: {
				action   : "installer_login",
				email    : email,
				password : pass,
				apikey   : apikey
			},
			error: () => { alert("E001. Please refresh the page!"); },
			success: (response) => {

				console.log(response);

				// Hide errorMsg & marningMsg
				$("#errorMsg, #warningMsg").addClass("d-none");

				// Show Error Message If Wront Email|Password
				if(!response || typeof response !== "object") {
					$("#errorMsg").removeClass("d-none");
					return;
				}

				// Get Correct Installer Flag
				var correct_installer = true;
				if(response.hasOwnProperty("correct_installer") && response.correct_installer == false) correct_installer = false;

				// Set to Session
				$.post({
					url: "cmd/session.php",
					data: {
						installer_email:     $("#email   ").val().trim(),
						installer_password:  $("#password").val(),
						installer_gender:    response.hasOwnProperty("gender"   ) ? response["gender"   ] : "0",
						installer_firstname: response.hasOwnProperty("firstname") ? response["firstname"] : "",
						installer_lastname:  response.hasOwnProperty("lastname" ) ? response["lastname" ] : "",
						installer_company:   response.hasOwnProperty("company"  ) ? response["company"  ] : "",
						installer_telephone: response.hasOwnProperty("telephone") ? response["telephone"] : "",
						installer_country:   response.hasOwnProperty("country"  ) ? response["country"  ] : ""
					},
					error: () => { alert("E002. Please refresh the page!"); },
					success: (response) => {
						console.log(response);
						if(response != "1") {
							alert("E003. Please refresh the page!");
							return;
						}
						// Show Warning Message If Wrong Installer
						if(correct_installer) {
							window.location.href = "customer_info.php";
						} else {
							$("#warningMsg").removeClass("d-none");
							isLoggedIn = true;
						}
					}
				});

			}
		});
	}

});
