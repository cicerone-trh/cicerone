$(document).ready(function () {

/******************************
 * TEMPORARY STUFF            *
 ******************************/
	$("#project-list li").click(function() {
		$(this).addClass("selected").siblings().removeClass("selected");
	});

/******************************
 * FORM VALIDATION            *
 ******************************/
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

/******************************
 * JS-LINK BEHAVIOR           *
 ******************************/

// implementing slide left & right


	/*
	$("#view-history-link").click(function() {
		var linkIndex = 0;
		var presentLink = 1;
		if ($("#view-history-link").hasClass("activeLink")) {

		} else {
			// link display 
			$(".activeLink").removeClass("activeLink");
			$(this).addClass("activeLink");

			// determine direction of sliding
			var inDirection, outDirection;

			if (linkIndex < presentLink) {
				inDirection = "left";
				outDirection = "right";
			} else {
				inDirection = "right";
				outDirection = "left";
			}

			// slide other out
			
			$(".active-component").addClass("component-transition");
			$(".active-component").hide('slide', {direction: outDirection}, 500);
			$(".active-component").removeClass("active-component component-transition");

			// slide history in
			
			$("#view-history").addClass("component-transition");
			$("#view-history").toggle('slide', {direction: inDirection}, 500);
			$("#view-history").addClass("active-component");
			$("#view-history").removeClass("component-transition");

		}
	});

	$("#add-activity-link").click(function() {
		if ($(this).hasClass("activeLink")) {
			
		} else {
			$(".activeLink").removeClass("activeLink");
			$(this).addClass("activeLink");

			var inDirection = "right";
			var outDirection = "left";

			// slide other out
			$(".active-component").hide('slide', {direction: outDirection}, 500);
			$(".active-component").removeClass("active-component");

			// slide this in
			//$("#add-activity").show();
			$("#add-activity").delay("100").toggle('slide', {direction: inDirection}, 500);
			$("#add-activity").addClass("active-component");
		}
	});


*/

	
	var homeLinks = [];

	homeLinks.push({
		linkid:"#view-history-link",
		blockid:"#view-history"
	});
	homeLinks.push({
		linkid:"#add-project-link",
		blockid:"#add-project",
	});
	homeLinks.push({
		linkid:"#add-activity-link",
		blockid:"#add-activity"
	});

	for (var i=0; i < homeLinks.length; i++) {
		createFamilyLink(
			homeLinks, 
			homeLinks[i].linkid, 
			homeLinks[i].blockid,
			homeLinks[i].extra
		);
	}

}); // end document onload

/******************************
 * FUNCTIONS                  *
 ******************************/

function createHomeLinks(linkFamily, linkid, blockid) {
	$(linkid).click(function() {
		// 	
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





