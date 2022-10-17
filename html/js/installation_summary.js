$progress.trigger("step", 5);





$("#checkboxAccept").on("click", () => {
	if($("#checkboxAccept").is(":checked"))
		$("#btnFinish").css("visibility", "visible");
	else
		$("#btnFinish").css("visibility", "hidden");
});





function getImageDimensions(file) {
	return new Promise (function (resolved, rejected) {
		var i = new Image();
		i.onload = function() { resolved({ w: i.width, h: i.height }) };
		i.src = file;
	});
}





$("#btnFinishInstallation").on("click", () => {

	$("#btnFinishInstallation").attr("disabled", "disabled");

	var data = new FormData();

	data.append("action", "finish_installation");
	data.append("has_device" , dataObj["has_device" ] == true ? "1" : "0");
	data.append("has_battery", dataObj["has_battery"] == true ? "1" : "0");

	data.append("lang", ["de","fr","cs","es"].includes($("#lang").val()) ? $("#lang").val() : "en");
	
	data.append("type", "xt");

	if(dataObj.hasOwnProperty("installation_date"     ) && dataObj["installation_date"     ] != "") data.append("installation_date"     , dataObj["installation_date"        ]);

	if(dataObj.hasOwnProperty("installer_gender"      ) && dataObj["installer_gender"      ] != "") data.append("installer_gender"      , dataObj["installer_gender"         ]);
	if(dataObj.hasOwnProperty("installer_firstname"   ) && dataObj["installer_firstname"   ] != "") data.append("installer_firstname"   , dataObj["installer_firstname"      ]);
	if(dataObj.hasOwnProperty("installer_lastname"    ) && dataObj["installer_lastname"    ] != "") data.append("installer_lastname"    , dataObj["installer_lastname"       ]);
	if(dataObj.hasOwnProperty("installer_company"     ) && dataObj["installer_company"     ] != "") data.append("installer_company"     , dataObj["installer_company"        ]);
	if(dataObj.hasOwnProperty("installer_telephone"   ) && dataObj["installer_telephone"   ] != "") data.append("installer_telephone"   , dataObj["installer_telephone"      ]);
	if(dataObj.hasOwnProperty("installer_email"       ) && dataObj["installer_email"       ] != "") data.append("installer_email"       , dataObj["installer_email"          ]);
	if(dataObj.hasOwnProperty("installer_password"    ) && dataObj["installer_password"    ] != "") data.append("installer_password"    , dataObj["installer_password"       ]);

	if(dataObj.hasOwnProperty("customer_gender"       ) && dataObj["customer_gender"       ] != "") data.append("customer_gender"       , dataObj["customer_gender"          ]);
	if(dataObj.hasOwnProperty("customer_firstname"    ) && dataObj["customer_firstname"    ] != "") data.append("customer_firstname"    , dataObj["customer_firstname"       ]);
	if(dataObj.hasOwnProperty("customer_lastname"     ) && dataObj["customer_lastname"     ] != "") data.append("customer_lastname"     , dataObj["customer_lastname"        ]);
	if(dataObj.hasOwnProperty("customer_email"        ) && dataObj["customer_email"        ] != "") data.append("customer_email"        , dataObj["customer_email"           ]);
	if(dataObj.hasOwnProperty("customer_telephone"    ) && dataObj["customer_telephone"    ] != "") data.append("customer_telephone"    , dataObj["customer_telephone"       ]);
	if(dataObj.hasOwnProperty("customer_company"      ) && dataObj["customer_company"      ] != "") data.append("customer_company"      , dataObj["customer_company"         ]);
	if(dataObj.hasOwnProperty("customer_country"      ) && dataObj["customer_country"      ] != "") data.append("customer_country"      , dataObj["customer_country"         ]);
	if(dataObj.hasOwnProperty("customer_city"         ) && dataObj["customer_city"         ] != "") data.append("customer_city"         , dataObj["customer_city"            ]);
	if(dataObj.hasOwnProperty("customer_zipcode"      ) && dataObj["customer_zipcode"      ] != "") data.append("customer_zipcode"      , dataObj["customer_zipcode"         ]);
	if(dataObj.hasOwnProperty("customer_address"      ) && dataObj["customer_address"      ] != "") data.append("customer_address"      , dataObj["customer_address"         ]);

	if(dataObj.hasOwnProperty("installation_country"  ) && dataObj["installation_country"  ] != "") data.append("installation_country"  , dataObj["installation_country"     ]);
	if(dataObj.hasOwnProperty("installation_city"     ) && dataObj["installation_city"     ] != "") data.append("installation_city"     , dataObj["installation_city"        ]);
	if(dataObj.hasOwnProperty("installation_zipcode"  ) && dataObj["installation_zipcode"  ] != "") data.append("installation_zipcode"  , dataObj["installation_zipcode"     ]);
	if(dataObj.hasOwnProperty("installation_address"  ) && dataObj["installation_address"  ] != "") data.append("installation_address"  , dataObj["installation_address"     ]);

	data.append("system_model", "batterX traX");
	if(dataObj.hasOwnProperty("system_serial"         ) && dataObj["system_serial"         ] != "") data.append("system_serial"         , dataObj["system_serial"            ]);

	if(dataObj.hasOwnProperty("device_serial"         ) && dataObj["device_serial"         ] != "") data.append("device_serial"         , dataObj["device_serial"            ]);
	if(dataObj.hasOwnProperty("device_model"          ) && dataObj["device_model"          ] != "") data.append("device_model"          , dataObj["device_model"             ]);
	if(dataObj.hasOwnProperty("solar_wattpeak"        ) && dataObj["solar_wattpeak"        ] != "") data.append("solar_wattpeak"        , dataObj["solar_wattpeak"           ]);
	if(dataObj.hasOwnProperty("solar_info"            )                                           ) data.append("solar_info"            , dataObj["solar_info"               ]);
	if(dataObj.hasOwnProperty("note"                  )                                           ) data.append("note"                  , dataObj["note"                     ]);

	if(dataObj.hasOwnProperty("box_apikey"            ) && dataObj["box_apikey"            ] != "") data.append("box_apikey"            , dataObj["box_apikey"               ]);
	if(dataObj.hasOwnProperty("box_serial"            ) && dataObj["box_serial"            ] != "") data.append("box_serial"            , dataObj["box_serial"               ]);
	if(dataObj.hasOwnProperty("software_version"      ) && dataObj["software_version"      ] != "") data.append("software_version"      , dataObj["software_version"         ]);

	data.append("battery_type"    , "other");
	data.append("battery_voltage" , "1"    );
	if(dataObj.hasOwnProperty("battery_capacity"      ) && dataObj["battery_capacity"      ] != "") data.append("battery_capacity"      , dataObj["battery_capacity"         ]);

	html2canvas(document.querySelector("#summary"), {
		windowWidth: 1200,
		scale: 2
	}).then(async canvas => {

		var img = canvas.toDataURL("image/jpeg");
		var dimensions = await getImageDimensions(img);

		var ratio = dimensions.w / dimensions.h;
		var w = 190, h = 190 / ratio;
		if(ratio < 0.68) { h = 277; w = 277 * ratio; }

		var pdf = new jsPDF("portrait", "mm", "a4");
		pdf.addImage(img, "JPEG", (210 - w) / 2, (297 - h) / 2, w, h); // img, type, x, y, width, height
		var pdfBlob = pdf.output("blob");

		// USE BLOB TO SAVE PDF-FILE TO CLOUD

		data.append("pdf_file", pdfBlob, lang.trax_summary.installation_summary);

		$.post({
			url: "https://api.batterx.app/v1/install.php",
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			error: () => { alert("Error, please try again!"); },
			success: (response) => {
				if(response == "1") {
					showSuccess();
				} else {
					$("#btnFinishInstallation").removeAttr("disabled");
					alert("Error: " + response);
				}
			}
		});

	});

});





function showSuccess() {
	$("#summary   ").hide();
	$("#confirm   ").hide();
	$("#btnFinish ").hide();
	$("#successBox").show();
	$("body").addClass("show-success");
}





$("#btnDownload").on("click", function() {
	html2canvas(document.querySelector("#summary"), {
		windowWidth: 1200,
		scale: 2,
		onclone: (clonedDoc) => { clonedDoc.getElementById("summary").style.display = "block"; }
	}).then(async canvas => {
		var img = canvas.toDataURL("image/jpeg");
		var dimensions = await getImageDimensions(img);
		var ratio = dimensions.w / dimensions.h;
		var w = 190, h = 190 / ratio;
		if(ratio < 0.68) { h = 277; w = 277 * ratio; }
		var pdf = new jsPDF("portrait", "mm", "a4");
		pdf.addImage(img, "JPEG", (210 - w) / 2, (297 - h) / 2, w, h); // img, type, x, y, width, height
		pdf.save(lang.trax_summary.installation_summary + ".pdf");
	});
});





var checkRebootInterval;

$("#btnReboot").on("click", () => {
	$.post({
		url: "cmd/reboot.php",
		success: (response) => { console.log(response); },
		error  : (response) => { console.log(response); }
	});
	setTimeout(() => { checkRebootInterval = setInterval(checkReboot_waitForError, 5000); }, 2500);
	// Disable Button
	$("#btnReboot").attr("disabled", "disabled");
	// Show Loading
	$(".notif").removeClass("loading error success").addClass("loading");
});

function checkReboot_waitForError() {
	$.get({
		url: "cmd/working.txt",
		cache: false,
		timeout: 2500,
		success: (response) => {
			if(!response) {
				clearInterval(checkRebootInterval);
				checkRebootInterval = undefined;
				checkRebootInterval = setInterval(checkReboot_waitForSuccess, 5000);
			}
		},
		error: () => {
			clearInterval(checkRebootInterval);
			checkRebootInterval = undefined;
			checkRebootInterval = setInterval(checkReboot_waitForSuccess, 5000);
		}
	});
}

function checkReboot_waitForSuccess() {
	$.get({
		url: "cmd/working.txt",
		cache: false,
		timeout: 2500,
		success: (response) => {
			if(response) {
				clearInterval(checkRebootInterval);
				checkRebootInterval = undefined;
				// Show Success
				$(".notif").removeClass("loading error success").addClass("success");
			}
		}
	});
}
