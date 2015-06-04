$(document).ready(function () {
	// onclick set li to selected, deselect other
	$("#project-list li").click(function() {
		$(this).addClass("selected").siblings().removeClass("selected");
	});

	// form validation
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

		return false;
	}
});
