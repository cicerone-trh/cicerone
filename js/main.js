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

	var listSpeed = 400;
	var formSpeed = 200;

	$(".activity-entry").find(".js-link").click(function() {

		if (!$(this).parent().find(".activity-description").hasClass("active-entry")){

			// hide currently active
			$(".active-entry").parent().find(".icons").fadeToggle();
			$(".active-entry").slideUp();
			$(".active-entry").removeClass("active-entry");

			// slide down description
			$(this).parent().find(".activity-description").toggle("slide down", function() {
				$(this).addClass("active-entry");
			});

			// toggle display icons
			$(this).parent().find(".icons").fadeToggle();

		} else {
			$(".active-entry").parent().find(".icons").fadeToggle();
			$(".active-entry").slideUp();
			$(".active-entry").removeClass("active-entry");
		}
	
	});

	$(".activity-entry").find(".d-icon").click(function() {
		var id = $(this).parent().data("id");
		if(window.confirm("Are you sure you want to delete this?")){
			window.location.href = "includes/delete_activity.php?id=" + id;
		} 
	});

	$(".activity-entry").find(".e-icon").click(function() {

		var editFormDiv = document.getElementById("edit-form");
		var actId = $(this).parent().data("id");

		createEditForm(editFormDiv, actId);
		$("#history-list").slideUp(listSpeed, function() {
			$("#edit-form-div").slideDown(formSpeed);
		});
	});

	$("#cancel-edit").click(function(){
		$("#edit-form-div").slideUp(formSpeed, function() {
			$("#history-list").slideDown(listSpeed, function() {
				$("#edit-form").html("");
			});
		});
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

function createEditForm(targetDiv, id) {

	// ajax to create values 

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","/includes/get_activity.php?id="+id, true);
	xmlhttp.send();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4) {
			if (xmlhttp.status === 200) {
				var activity = JSON.parse(xmlhttp.responseText);
				
				// building form from ajax values
		
				var addActivityForm = document.getElementById("addActivity");
				var updateForm = addActivityForm.cloneNode(true);

				// hidden field that includes id
				var idField = document.createElement("input");
				idField.setAttribute("type","hidden");
				idField.setAttribute("name","id");
				idField.setAttribute("value",id);
				updateForm.appendChild(idField);

				var hours = Math.floor(activity.duration / 3600);
				activity.duration = activity.duration % 3600;
				var minutes = activity.duration / 60;

				updateForm.setAttribute('name',"updateActivity");

				updateForm.name.setAttribute('value',activity.name);
				updateForm.duration_h.setAttribute('value',hours);
				updateForm.duration_m.setAttribute('value',minutes);

				updateForm.description.innerHTML = activity.description;

				updateForm.types.setAttribute('value',activity.types);

				// need to get the index of the option w/value = project_id
				var opts = updateForm.project_id.options;
				for (var i=0; i < opts.length; i++) {
					if (opts[i].value == activity.project_id){
						opts[i].setAttribute("selected","selected");
						break;
					}
				}

				updateForm.uriLink.setAttribute('value',activity.uriLink);
				updateForm.add_activity.setAttribute('value',"Update");
				updateForm.add_activity.setAttribute('name',"mod_activity");
				
				targetDiv.appendChild(updateForm);

			}	
		}
	}


}
