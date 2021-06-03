"use strict";
// Define your library strictly...
function updateIcon1(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview1').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon1").on('change', function() {
	updateIcon1(this);
});

function updateIcon2(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview2').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon2").on('change',function() {
	updateIcon2(this);
});

function updateIcon3(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview3').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon3").on('change', function() {
	updateIcon3(this);
});

function updateIcon4(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview4').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon4").on('change', function() {
	updateIcon4(this);
});

function updateIcon5(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview5').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon5").on('change', function() {
	updateIcon5(this);
});

function updateIcon6(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview6').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon6").on('change', function() {
	updateIcon6(this);
});

function updateIcon7(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview7').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon7").on('change', function() {
	updateIcon7(this);
});

function updateIcon8(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview8').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon8").on('change', function() {
	updateIcon8(this);
});

function updateIcon9(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#preview9').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#icon9").on('change', function() {
	updateIcon9(this);
});
