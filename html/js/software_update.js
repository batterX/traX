$progress.trigger("step", 1);





var newVersion = softwareVersion;

var checkUpdateInterval;





performUpdate();

function performUpdate() {

	$.get({
		url: "https://api.batterx.app",
		dataType: "text",
		cache: false,
		error: () => {
			// Connection Lost
			$("#notif").removeClass("loading error success").addClass("error");
			$("#message").html(lang.software_update.no_internet_connection).css("color", "red");
			$("#errorInfo").removeClass("d-none");
			setTimeout(performUpdate, 5000); // Retry after 5 seconds
		},
		success: () => {

			// Search for Updates
			$("#notif").removeClass("loading error success").addClass("loading");
			$("#message").html(lang.software_update.searching_for_updates).css("color", "black");
			$("#errorInfo").addClass("d-none");

			// Get Latest Version Number
			$.get({
				url: "https://raw.githubusercontent.com/batterX/traX/master/version.txt",
				dataType: "text",
				cache: false,
				error: () => {
					$("#notif").removeClass("loading error success").addClass("error");
					$("#message").html(lang.software_update.no_internet_connection).css("color", "red");
					$("#errorInfo").removeClass("d-none");
					setTimeout(performUpdate, 5000);
				},
				success: (versionNum) => {

					// Compare Versions
					if(softwareVersion != versionNum) {
						newVersion = versionNum;
						// Download Update
						$.post("cmd/update.php");
						// Downloading Update...
						$("#message").html(lang.software_update.downloading_update);
						clearInterval(checkUpdateInterval);
						checkUpdateInterval = undefined;
						checkUpdateInterval = setInterval(checkUpdate_waitForError, 5000);
					} else {
						// Update Completed
						$("#notif").removeClass("loading error success").addClass("success");
						$("#message").html(lang.software_update.update_completed).css("color", "#28a745");
						$("#btn_next").attr("disabled", false);
						setTimeout(() => { window.location.href = "installer_login.php?software_version=" + newVersion; }, 5000);
					}

				}
			});

		}
	});
	
}





function checkUpdate_waitForError() {
	$.get({
		url: "cmd/working.txt",
		cache: false,
		error: () => {
			// Rebooting...
			$("#message").html(lang.software_update.rebooting);
			clearInterval(checkUpdateInterval);
			checkUpdateInterval = undefined;
			checkUpdateInterval = setInterval(checkUpdate_waitForSuccess, 5000);
		},
		success: (response) => {
			if(response) return;
			// Rebooting...
			$("#message").html(lang.software_update.rebooting);
			clearInterval(checkUpdateInterval);
			checkUpdateInterval = undefined;
			checkUpdateInterval = setInterval(checkUpdate_waitForSuccess, 5000);
		}
	});
}

function checkUpdate_waitForSuccess() {
	$.get({
		url: "cmd/working.txt",
		cache: false,
		success: (response) => {
			if(!response) return;
			// Finishing Update...
			$("#message").html(lang.software_update.finishing_update);
			clearInterval(checkUpdateInterval);
			checkUpdateInterval = undefined;
			setTimeout(() => {
				// Update Completed
				$("#notif").removeClass("loading error success").addClass("success");
				$("#message").html(lang.software_update.update_completed).css("color", "#28a745");
				$("#btn_next").attr("disabled", false);
				setTimeout(() => { window.location.href = "installer_login.php?software_version=" + newVersion; }, 5000);
			}, 60000);
		}
	});
}





$("#btn_next").on("click", () => { window.location.href = "installer_login.php?software_version=" + newVersion; });
