// Get locked
// app.js

// AJAX Submit Helpers

function getDoc(frame) {
	var doc = null;

	// IE8 cascading access check
	try {
		if (frame.contentWindow) {
			doc = frame.contentWindow.document;
		}
	} catch(err) {
	}
 
	if (doc) { // successful getting content
		return doc;
	}

	try { // simply checking may throw in ie8 under ssl or mismatched protocol
		doc = frame.contentDocument ? frame.contentDocument : frame.document;
	} catch(err) {
		// last attempt
		doc = frame.document;
	}
	return doc;
}

function ajaxSubmit(form, success, failure) {

	success = typeof success !== 'undefined' ? success : function(response) {};
	failure = typeof failure !== 'undefined' ? failure : function(response) {};

	form.submit(function(e) {
		var formObj = $(this);
		var formURL = formObj.attr("action");
		console.log(formObj);

		if(window.FormData !== undefined) { // for HTML5 browsers

			var formData = new FormData(this);
			$.ajax({
				url: formURL,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data, textStatus, jqXHR)
				{
					var response = JSON.parse(data);
					console.log(response);

					if (response.status == 200) {
						return success(response, formURL); // Actual Success
					} else {
						return failure(response, formURL); // Actual Failure
					}
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					console.log("error");
				}
			});
			e.preventDefault();
			// e.unbind();
		} else { //for olden browsers
			//generate a random id
			var iframeId = 'unique' + (new Date().getTime());

			//create an empty iframe
			var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');

			//hide it
			iframe.hide();

			//set form target to iframe
			formObj.attr('target',iframeId);

			//Add iframe to body
			iframe.appendTo('body');
			iframe.load(function(e) {
				var doc = getDoc(iframe[0]);
				var docRoot = doc.body ? doc.body : doc.documentElement;
				var data = docRoot.innerHTML;
				//data is returned from server.
			});
		}
	});
}

// CORS Request Helper

function createCORSRequest(method, url) {
  var xhr = new XMLHttpRequest();
  if ("withCredentials" in xhr) {

    // Check if the XMLHttpRequest object has a "withCredentials" property.
    // "withCredentials" only exists on XMLHTTPRequest2 objects.
    xhr.open(method, url, true);

  } else if (typeof XDomainRequest != "undefined") {

    // Otherwise, check if XDomainRequest.
    // XDomainRequest only exists in IE, and is IE's way of making CORS requests.
    xhr = new XDomainRequest();
    xhr.open(method, url);

  } else {

    // Otherwise, CORS is not supported by the browser.
    xhr = null;

  }
  return xhr;
}

// Fill views with data

function fillGetStartedView() {
	$("form#signup-form").submit(function(e){
		e.preventDefault();

		// https://agent.electricimp.com/EbbcCn0OZAA-/lock/open
		// $.ajax({
		// 	url: "https://agent.electricimp.com/EbbcCn0OZAA-/lock/open",
		// 	type: 'GET',
		// 	contentType: false,
		// 	cache: false,
		// 	processData:false,
		// 	success: function(data, textStatus, jqXHR)
		// 	{
		// 		console.log("success", data);
		// 	},
		// 	error: function(jqXHR, textStatus, errorThrown)
		// 	{
		// 		console.log("failure");
		// 	}
		// });

		var url = "//api.get-locked.com/users";
		var xhr = createCORSRequest('GET', url);
		if (!xhr) {
		  throw new Error('CORS not supported');
		}
		
		var formdata = new FormData();
		formdata.append("email", $(this).find('input[name="mail"]').val());
		formdata.append("password", $(this).find('input[name="pass"]').val());

		$.support.cors = true;
		$.ajax({
			url: url,
			type: 'POST',
			data: formdata,
			crossDomain: true,
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
			success: function(data, textStatus, jqXHR)
			{
				var response = JSON.parse(data);
				if (response.status == 200) {
					signUpSuccess(response);
				} else {
					signUpFailure(response);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				alert("An unexpected error occurred.");
			}
		});

		return false;
	});
}

function fillLocksView() {

}

function fillLockEditView() {
	
}

function fillProfileView() {
	
}

function fillUserLogView() {

}

function fillLockLogView() {

}

// Form handlers

function signUpSuccess(response) {
	console.log("signup successful");
}
function signUpFailure(response) {

}

function sampleSuccess(response) {

}
function sampleFailure(response) {

}

function loginSuccess(response) {

}
function loginFailure(response) {

}

function profileUpdateSuccess(response) {

}
function profileUpdateFailure(response) {

}

function profileDeleteSuccess(response) {

}
function profileDeleteFailure(response) {

}

function lockRegisterSuccess(response) {

}
function lockRegisterFailure(response) {

}

function lockEditSuccess(response) {

}
function lockEditFailure(response) {

}

function lockDeleteSuccess(response) {

}
function lockDeleteFailure(response) {

}

function lockAddUserSuccess(response) {

}
function lockAddUserFailure(response) {

}

function lockRemoveUserSuccess(response) {

}
function lockRemoveUserFailure(response) {

}

// Document.ready

$(document).ready(function() {
	// Load document data

	fillGetStartedView();
	fillLocksView();
	fillLockEditView();
	fillProfileView();
	fillUserLogView();
	fillLockLogView();
	
	// Register form submission handlers

	ajaxSubmit($("form#sample-form"), sampleSuccess, sampleFailure);
	
	
	// ajaxSubmit($("form#signup-form"), signUpSuccess, signUpFailure);
	ajaxSubmit($("form#login-form"), loginSuccess, loginFailure);
	ajaxSubmit($("form#profile-update-form"), profileUpdateSuccess, profileUpdateFailure);
	ajaxSubmit($("form#profile-delete-form"), profileDeleteSuccess, profileDeleteFailure);

	ajaxSubmit($("form#lock-register-form"), lockRegisterSuccess, lockRegisterFailure);
	ajaxSubmit($("form#lock-edit-form"), lockEditSuccess, lockEditFailure);
	ajaxSubmit($("form#lock-delete-form"), lockDeleteSuccess, lockDeleteFailure);

	ajaxSubmit($("form#lock-add-user-form"), lockAddUserSuccess, lockAddUserFailure);
	ajaxSubmit($("form#lock-remove-user-form"), lockRemoveUserSuccess, lockRemoveUserFailure);
});









