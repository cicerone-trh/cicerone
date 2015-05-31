$(document).ready(function () {
	// onclick set li to selected, deselect other
	$("#project-list li").click(function() {
		$(this).addClass("selected").siblings().removeClass("selected");
	});
});
