$progress.trigger("step", 5);





$("#checkboxAccept").on("click", () => {
	if($("#checkboxAccept").is(":checked"))
		$("#btnFinish").css("visibility", "visible");
	else
		$("#btnFinish").css("visibility", "hidden");
});





$("#btnFinishInstallation").on("click", () => {

	$("#btnFinishInstallation").attr("disabled", "disabled");

	var data = new FormData();

	data.append("action" , "finish_installation");
	data.append("lang"   , ["de", "fr", "cs", "es"].includes($("#lang").val()) ? $("#lang").val() : "en");

	if(dataObj.hasOwnProperty("installation_date"   ) && dataObj["installation_date"   ] != "") data.append("installation_date"   , dataObj["installation_date"   ]);

	if(dataObj.hasOwnProperty("installer_gender"    ) && dataObj["installer_gender"    ] != "") data.append("installer_gender"    , dataObj["installer_gender"    ]);
	if(dataObj.hasOwnProperty("installer_firstname" ) && dataObj["installer_firstname" ] != "") data.append("installer_firstname" , dataObj["installer_firstname" ]);
	if(dataObj.hasOwnProperty("installer_lastname"  ) && dataObj["installer_lastname"  ] != "") data.append("installer_lastname"  , dataObj["installer_lastname"  ]);
	if(dataObj.hasOwnProperty("installer_company"   ) && dataObj["installer_company"   ] != "") data.append("installer_company"   , dataObj["installer_company"   ]);
	if(dataObj.hasOwnProperty("installer_telephone" ) && dataObj["installer_telephone" ] != "") data.append("installer_telephone" , dataObj["installer_telephone" ]);
	if(dataObj.hasOwnProperty("installer_email"     ) && dataObj["installer_email"     ] != "") data.append("installer_email"     , dataObj["installer_email"     ]);
	if(dataObj.hasOwnProperty("installer_password"  ) && dataObj["installer_password"  ] != "") data.append("installer_password"  , dataObj["installer_password"  ]);

	if(dataObj.hasOwnProperty("customer_gender"     ) && dataObj["customer_gender"     ] != "") data.append("customer_gender"     , dataObj["customer_gender"     ]);
	if(dataObj.hasOwnProperty("customer_firstname"  ) && dataObj["customer_firstname"  ] != "") data.append("customer_firstname"  , dataObj["customer_firstname"  ]);
	if(dataObj.hasOwnProperty("customer_lastname"   ) && dataObj["customer_lastname"   ] != "") data.append("customer_lastname"   , dataObj["customer_lastname"   ]);
	if(dataObj.hasOwnProperty("customer_email"      ) && dataObj["customer_email"      ] != "") data.append("customer_email"      , dataObj["customer_email"      ]);
	if(dataObj.hasOwnProperty("customer_telephone"  ) && dataObj["customer_telephone"  ] != "") data.append("customer_telephone"  , dataObj["customer_telephone"  ]);
	if(dataObj.hasOwnProperty("customer_company"    ) && dataObj["customer_company"    ] != "") data.append("customer_company"    , dataObj["customer_company"    ]);
	if(dataObj.hasOwnProperty("customer_country"    ) && dataObj["customer_country"    ] != "") data.append("customer_country"    , dataObj["customer_country"    ]);
	if(dataObj.hasOwnProperty("customer_city"       ) && dataObj["customer_city"       ] != "") data.append("customer_city"       , dataObj["customer_city"       ]);
	if(dataObj.hasOwnProperty("customer_zipcode"    ) && dataObj["customer_zipcode"    ] != "") data.append("customer_zipcode"    , dataObj["customer_zipcode"    ]);
	if(dataObj.hasOwnProperty("customer_address"    ) && dataObj["customer_address"    ] != "") data.append("customer_address"    , dataObj["customer_address"    ]);

	if(dataObj.hasOwnProperty("installation_country") && dataObj["installation_country"] != "") data.append("installation_country", dataObj["installation_country"]);
	if(dataObj.hasOwnProperty("installation_city"   ) && dataObj["installation_city"   ] != "") data.append("installation_city"   , dataObj["installation_city"   ]);
	if(dataObj.hasOwnProperty("installation_zipcode") && dataObj["installation_zipcode"] != "") data.append("installation_zipcode", dataObj["installation_zipcode"]);
	if(dataObj.hasOwnProperty("installation_address") && dataObj["installation_address"] != "") data.append("installation_address", dataObj["installation_address"]);

	if(dataObj.hasOwnProperty("box_apikey"          ) && dataObj["box_apikey"          ] != "") data.append("box_apikey"          , dataObj["box_apikey"          ]);
	if(dataObj.hasOwnProperty("box_serial"          ) && dataObj["box_serial"          ] != "") data.append("box_serial"          , dataObj["box_serial"          ]);
	if(dataObj.hasOwnProperty("software_version"    ) && dataObj["software_version"    ] != "") data.append("software_version"    , dataObj["software_version"    ]);

	if(dataObj.hasOwnProperty("box_serial"          ) && dataObj["box_serial"          ] != "") data.append("system_serial"       , dataObj["box_serial"          ]);
	
	data.append("system_model", "batterX traX");

	$.post({
		url: "https://api.batterx.io/v3/install_trax.php",
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





function showSuccess() {
	$("#summary   ").hide();
	$("#confirm   ").hide();
	$("#btnFinish ").hide();
	$("#successBox").show();
	$("body").addClass("show-success");
}
