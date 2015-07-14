$(document).ready(function () {

	// first, we will determine how many items to list
	// then, we will make the ajax call to populate the default list
	// just going to assume 6 lines is the max, but could figure it out by:
		// find longest string in descriptions; 


/******************************
 * DEFAULT PAGE LINKS         *
 ******************************/

	$("#more-about").click(function() {
		$("#about-1").hide('slide', {direction: "left"}, 300, function(){
			$("#about-2").show('slide', {direction: "right"}, 300);
		});
	});

	$("#less-about").click(function() {
		$("#about-2").hide('slide', {direction: "right"}, 300, function(){
			$("#about-1").show('slide', {direction: "left"}, 300);
		});
	});

	$("#create-link").click(function() {
		$("#login-form").slideUp(300, function() {
			$("#create-form").slideDown(300);
		});
	});

	$("#login-link").click(function() {
		$("#create-form").slideUp(300, function() {
			$("#login-form").slideDown(300);
		});
	});

	addHomeLink("#about-link", "#about-cic");		
	addHomeLink("#view-link", "#view-cic");		
	addHomeLink("#donate-link", "#donate-cic");	
	addHomeLink("#account-link", "#account-form");	

/******************************
 * ACTIVITY LIST CONTROLS     *
 ******************************/

	buildActivityDisplayLinks(".activity-entry");
	buildActivityDeleteLinks(".activity-entry", "includes/delete_activity.php?id=");
	buildActivityEditLinks(".activity-entry", createEditActivityForm);
	buildListControlLinks("#moreActivitiesLink", 'data-more');
	buildListControlLinks("#lessActivitiesLink", 'data-less');

/******************************
 * PROJECT LIST CONTROLS      *
 ******************************/
	$("#showProjectLink").click(function() {
		var project = $("#projectList").find(".selected");
		var activityListDiv = document.getElementById("history-list");

		$("#edit-form-div").hide("slide", {direction:"up"}, 200);
		$("#history-list").slideUp(500, function() {
			listProject(activityListDiv, project.data("projectid"));
		});
	});

	$("#editProjects").click(function() {
		var activityListDiv = document.getElementById("history-list");

		// here we go!
		// scroll up history and header
		$("#edit-form-div").hide("slide", {direction:"up"}, 200);
		$("#history-list").slideUp(500, function() {
			showProjectEditList(activityListDiv);
		});
	});

	$("#projectList li").click(function() {
		$("#projectListControls").addClass("clickable");
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
		activityForm.onsubmit = function() {
			return validateActivity(activityForm);
		}
	}

/******************************
 * PROCESS MESSAGE            *
 ******************************/

	$("#processMessage").delay(1500).fadeOut(function() {
		$(this).html("");
		$(this).show();
	});

	$("#processMessage").on("processResult", function() {
		$(this).delay(1500).fadeOut(function() {
			$(this).html("");
			$(this).show();
		});
	});

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
// 	buildListControlLinks("#moreActivitiesLink", 'data-more');
//
function buildListControlLinks(targetDiv, targetAttr) {

	$(targetDiv).click(function() {
		var index = $("#listData").attr(targetAttr);

		// create ajax request for more items
		var xmlhttp = new XMLHttpRequest;

		xmlhttp.open("GET", "/includes/ajax.php?act=getActs&index=" + index, true);
		xmlhttp.send();

		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4) {

				$("#history-list").html(xmlhttp.responseText);

				var isLess = $("#listData").attr('data-less');
				var isMore = $("#listData").attr('data-more');

				if (isMore > 0) {
					$("#moreActivitiesLink").show();
				} else {
					$("#moreActivitiesLink").hide();
				}
				
				if (isLess >= 0) {
					$("#lessActivitiesLink").show();
				} else {
					$("#lessActivitiesLink").hide();
				}

				buildActivityDisplayLinks(".activity-entry");
				buildActivityDeleteLinks(".activity-entry", "includes/delete_activity.php?id=");
				buildActivityEditLinks(".activity-entry", createEditActivityForm);

			}
		}
	});

}

function showProjectEditList(targetDiv) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "/includes/ajax.php?act=editProjects", true);
	xmlhttp.send();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4) {
			$("#history_header h2").html("Edit Projects");
			targetDiv.innerHTML = xmlhttp.responseText;

			buildActivityDisplayLinks(".projectDetails");
			buildActivityDeleteLinks(".projectDetails", "includes/process.php?delproj=");
			buildActivityEditLinks(".projectDetails", createEditProjectForm);

			// toggle checkboxes script
			$(".projectDetails").find("input").change(function() {
				$(this).attr("disabled", true);
				var box = $(this);
				var name = $(this).parent().parent().find(".js-link").text();		// lol, tired
				var id = $(this).data("id");
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "/includes/ajax.php?act=toggleActive&id=" + id, true);
				xmlhttp.send();

				xmlhttp.onreadystatechange = function () {
					if (xmlhttp.readyState === 4) {
						var processMessage;

						// update activity list in add activity

						if ($(box).is(":checked")){
							$("#projectSelectInput").append('<option value="' + id + '">' + name + '</option>');
							processMessage = "Project active!";
						} else {
							$("#projectSelectInput option[value='" + id + "']").remove();
							processMessage = "Project inactive!";
						}
						$("#processMessage").html(processMessage);



						window.setTimeout(function() {
							$(box).removeAttr('disabled');
							$("#processMessage").trigger("processResult");
						}, 650);
					}
				}
			});

			$(targetDiv).slideDown();
		}
	}
}

function listProject(targetDiv, id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "/includes/ajax.php?act=loadProject&id="+id, true);
	xmlhttp.send();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4){

			// projectName by finding corresponding innerHTML of project list with 
			var projectName = (id == 0 ? "" : 
				$("#projectList").find('*[data-projectid="'+id+'"]').html());
			
			// changing header text
			$("#history_header h2").html("Activity History: " + projectName);

			// changing list: ajax.php builds the html
			targetDiv.innerHTML = xmlhttp.responseText;

			var isLess = $("#listData").attr('data-less');
			var isMore = $("#listData").attr('data-more');

			if (isMore > 0) {
				$("#moreActivitiesLink").show();
			} else {
				$("#moreActivitiesLink").hide();
			}
			
			if (isLess >= 0) {
				$("#lessActivitiesLink").show();
			} else {
				$("#lessActivitiesLink").hide();
			}

			// adding js links for each item
			buildActivityDisplayLinks(".activity-entry");
			buildActivityDeleteLinks(".activity-entry", "includes/delete_activity.php?id=");
			buildActivityEditLinks(".activity-entry", createEditActivityForm);

			// display new list
			$(targetDiv).slideDown();
		}
	}
}

// build links vars
var headerSpeed = 150;
var listSpeed = 400;
var formSpeed = 200;

// creates links to toggle an item's display
function buildActivityDisplayLinks(activityClass) {
	$(activityClass).find(".js-link").click(function() {

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
}

// creates links for delete icons
function buildActivityDeleteLinks(activityClass, delUrl) {
	$(activityClass).find(".d-icon").click(function() {
		var id = $(this).parent().data("id");
		if(window.confirm("Are you sure you want to delete this?")){
			window.location.href = delUrl + id;
		} 
	});
}

function buildActivityEditLinks(activityClass,formGenerator) {
	$(activityClass).find(".e-icon").click(function() {

		var editFormDiv = document.getElementById("edit-form");
		editFormDiv.innerHTML = "";
		var actId = $(this).parent().data("id");

		formGenerator(editFormDiv, actId);

		oldHeader = $("#history_header h2").html();
		$("#history-list").slideUp(listSpeed, function() {
			$("#history_header").slideUp(headerSpeed, function() {
				$("#history_header h2").html("Update Entry: ");
				$("#history_header").slideDown(headerSpeed, function() {
					$("#edit-form-div").slideDown(formSpeed);
				});
			});
		});
	});

	$("#cancel-edit").click(function(){
		$("#edit-form-div").slideUp(formSpeed, function() {
			$("#history_header").slideUp(headerSpeed, function() {
				$("#history_header h2").html(oldHeader);
				$("#history_header").slideDown(headerSpeed, function() {
					$("#history-list").slideDown(listSpeed, function() {
						$("#edit-form").html("");
					});
				});
			});
		});
	});
}

function createEditActivityForm(targetDiv, id) {

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

				// creating hours and minutes from duration
				var hours = Math.floor(activity.duration / 3600);
				activity.duration = activity.duration % 3600;
				var minutes = activity.duration / 60;

				// modifying values and attributes
				updateForm.setAttribute('name',"updateActivity");

				updateForm.name.value = activity.name;
				updateForm.duration_h.value = hours;
				updateForm.duration_m.value = minutes;
				updateForm.description.innerHTML = activity.description;
				updateForm.types.value = activity.types;

				// need to get the index of the option w/value = project_id
				var opts = updateForm.project_id.options;
				for (var i=0; i < opts.length; i++) {
					if (opts[i].value == activity.project_id){
						opts[i].setAttribute("selected","selected");
						break;
					}
				}

				updateForm.uriLink.value = activity.uriLink;
				updateForm.add_activity.setAttribute('value',"Update");
				updateForm.add_activity.setAttribute('name',"mod_activity");
				updateForm.onsubmit = function() {
					return validateActivity(updateForm);
				}
				
				targetDiv.appendChild(updateForm);

			}	
		}
	}
}

function createEditProjectForm(targetDiv, id) {
	
	// ajax to create values 

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET",'/includes/ajax.php?act=echoProject&id='+id, true);
	xmlhttp.send();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4) {
			if (xmlhttp.status === 200) {
				var project = JSON.parse(xmlhttp.responseText);
				
				// building form from ajax values
		
				var addProjectForm = document.getElementById("addProject");
				var updateForm = addProjectForm.cloneNode(true);

				// hidden field that includes id
				var idField = document.createElement("input");
				idField.setAttribute("type","hidden");
				idField.setAttribute("name","id");
				idField.setAttribute("value",id);
				updateForm.appendChild(idField);

				// modifying values and attributes
				updateForm.setAttribute('name',"updateProject");

				updateForm.project.value = project.name;
				updateForm.isActive.checked = project.isActive == 1 ? true : false;

				updateForm.description.innerHTML = project.description;
				updateForm.uriLink.value = project.uriLink;

				updateForm.add_project.setAttribute('value',"Update");
				updateForm.add_project.setAttribute('name',"mod_project");
				updateForm.onsubmit = function() {
					return validateProject(updateForm);
				}
				
				targetDiv.appendChild(updateForm);

			}	
		}
	}
}

function validateProject(projectForm) {
	var isValid = true;
	var hasValue = /\S/;

	if (!hasValue.test(projectForm.project.value)){
		alert("The project needs a name.");
		isValid = false;
	}

	if (!hasValue.test(projectForm.description.value)){
		alert("The project needs a description.");
		isValid = false;
	}

	return isValid;
}

function validateActivity(activityForm) {
	var isValid = true;

	var hasValue = /\S/;
	var nonNum = /\D/;

	if (!hasValue.test(activityForm.name.value)){
		alert("The activity needs a name.");
		isValid = false;
	}

	if (nonNum.test(activityForm.duration_h.value) || nonNum.test(activityForm.duration_m.value)){
		alert("Durations can only be positive numbers.");
		isValid = false;
	}

	if (!hasValue.test(activityForm.name.value)){
		alert("The activity needs a description.");
		isValid = false;
	}

	return isValid;
}

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
