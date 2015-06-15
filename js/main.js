$(document).ready(function () {
/******************************
 * DEFAULT PAGE LINKS         *
 ******************************/
	
	$("#create-link").click(function() {
		$("#login-form").slideUp();
		$("#create-form").delay(400).slideDown(300);
	});

	$("#login-link").click(function() {
		$("#create-form").slideUp();
		$("#login-form").delay(400).slideDown(300);
	});

	addHomeLink("#about-link", "#about-cic");		
	addHomeLink("#view-link", "#view-cic");		
	addHomeLink("#donate-link", "#donate-cic");	
	addHomeLink("#account-link", "#account-form");	

/******************************
 * ACTIVITY LIST CONTROLS     *
 ******************************/

	$(".activity-entry").find(".js-link").click(function() {
		$(this).parent().find(".activity-description").toggle("slide down");
	});

/******************************
 * PROJECT LIST CONTROLS      *
 ******************************/
	//$("").click(function() {

	//});


/******************************
 * TEMPORARY STUFF            *
 ******************************/
	$("#project-list li").click(function() {
		$("#project-list-controls").addClass("clickable");
		$(this).addClass("selected").siblings().removeClass("selected");
	});

/******************************
 * FORM VALIDATION            *
 ******************************/
	if (document.forms['loginForm']) {
		var createForm = document.forms['createAccount'];
		var errorDiv = document.querySelector('footer');	

		createForm.onsubmit = function () {
			var isValid = true;
			errorDiv.innerHTML = "";

			if (!createForm.new_username.value.match(/\S/)){
				var errorText = document.createTextNode("Username can't be blank.");
				errorDiv.appendChild(errorText);
				isValid = false;
			}

			if (!createForm.new_password.value.match(/\S/)){
				var errorText = document.createTextNode("Password can't be blank.");
				errorDiv.appendChild(errorText);
				isValid = false;
			}

			return isValid;
		}
	}

	if (document.forms['addActivity']) {

		var activityForm = document.forms['addActivity'];

		activityForm.onsubmit = function validateInput() {
			var isValid = true;

			if (!activityForm.name.value.match(/\S/)){
				alert("The activity needs a name");
				isValid = false;
			}

			if (!activityForm.duration_h.value.match(/\S/) && !activityForm.duration_m.value.match(/\S/)){
				alert("Some duration is needed");
				isValid = false;
			}

			// if either duration fields are non-numeric

			if (!activityForm.description.value.match(/\S/)){
				alert("A description is required");
				isValid = false;
			}

			return isValid;
		}

	}

/******************************
 * JS-LINK BEHAVIOR           *
 ******************************/
	// implementing slide left & right

	addHomeLink("#view-history-link", "#view-history");		
	addHomeLink("#add-project-link", "#add-project");		
	addHomeLink("#add-activity-link", "#add-activity");	

}); // end document onload

/******************************
 * FUNCTIONS                  *
 ******************************/

function addHomeLink(linkid, blockid) {
	$(linkid).click(function() {
		var inDir, outDir;
		if (!$(linkid).hasClass("activeLink")) {
			
			// determine direction
			if ($(linkid).data("order") > $('.activeLink').data("order")) {
				outDir = "left";	
				inDir = "right";
			} else {
				outDir = "right";
				inDir = "left";
			}

			// changing linkness
			$('.activeLink').removeClass("activeLink");
			$(linkid).addClass("activeLink");

			// slide out out
			$(".active-component").hide('slide', {direction: outDir}, 300);
			$(".active-component").removeClass("active-component");
			
			// slide this in
			$(blockid).delay("300").show('slide', {direction: inDir}, 300);
			$(blockid).addClass("active-component");
		}
	});
}


function createFamilyLink(linkFamily, linkid, blockid, extra) {
	$(linkid).click(function() {
		// slideup the other blocks; i=0 is default block
		for (var i=1; i < linkFamily.length; i++) {
			if (linkFamily[i].linkid != linkid) {
				$(linkFamily[i].linkid).removeClass("activeLink");
				$(linkFamily[i].blockid).slideUp();
			} 
		}
		// slidedown the targetblock
		if (!$(blockid).is(":hidden")){
			$(blockid).slideUp();
			$(linkid).removeClass("activeLink");
			$(linkFamily[0].blockid).delay(400).slideDown(300);
		} else {
			$(linkFamily[0].blockid).slideUp();
			$(linkid).addClass("activeLink");
			$(blockid).delay(400).slideDown(300, extra);
		}
	});
}





