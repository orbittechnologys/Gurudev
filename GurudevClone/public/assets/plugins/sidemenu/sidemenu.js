(function () {
	"use strict";

	var slideMenu = $('.side-menu');
	$('.app').addClass('sidebar-mini');
	if($(window).width() < 767) {

		$('.app').removeClass(' sidenav-toggled ');
		$('.app').addClass(' sidenav-toggled1 ');
	}
	else {
		$('.app').addClass(' sidenav-toggled ');
		$('.app').removeClass(' sidenav-toggled1 ');
	}
/*
	// Toggle Sidebar
	$(document).on("click", "[data-toggle='sidebar']", function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');

	});
	$(document).on("click", ".sidenav-toggled .nav-link.toggle", function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled1');
	});*/
/*	$(document).on("click", ".sidenav-toggled .resp-tab-item", function(event) {
		event.preventDefault();

	});*/
	
	//mobile  Toggle Sidebar


		$(document).on("click", "[data-toggle='sidebar']", function(event) {
			event.preventDefault();
			$('.app').toggleClass('sidenav-toggled sidenav-toggled1');
			$('.app').removeClass('sidenav-toggled4');


		});
		



	
	// Activate sidebar slide toggle
	$(document).on("click", "[data-toggle='slide']", function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			slideMenu.find("[data-toggle='slide']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();
	$(".MainMenu").on("click", function(event) {
		var single_nav1='sidenav-toggled4'
		var single_nav2='sidenav-toggled sidenav-toggled4'
		if ($(this).hasClass("single")) {
			single_nav1=''
			var single_nav2='sidenav-toggled '
		}
		if ($(window).width() < 767) {
			if ($(this).hasClass("MainMenuActive")) {
				$('.app').removeClass(' sidenav-toggled sidenav-toggled4');
				$(".MainMenu").removeClass('MainMenuActive');
			} else {

				$(".MainMenu").removeClass('MainMenuActive');
				$(this).addClass('MainMenuActive');
				$('.app').addClass(single_nav2);
			}
		}
		else {
			if ($(this).hasClass("MainMenuActive")) {
				$('.app').removeClass(single_nav1);
				$(".MainMenu").removeClass('MainMenuActive');
			} else {

				$(".MainMenu").removeClass('MainMenuActive');
				$(this).addClass('MainMenuActive');
				$('.app').addClass(single_nav1);
			}
		}
	});
	$(".header, .app-content").on("click mouseenter", function(event) {
		if($(window).width() < 767) {

			$('.app').addClass('sidenav-toggled1');
			$(".MainMenu").removeClass('MainMenuActive');
		}
		else {
			$('.app').removeClass('sidenav-toggled4');
			$(".MainMenu").removeClass('MainMenuActive');
		}



	});

	$(window).on('resize', function() {
		if($(window).width() < 767) {

			$('.app').removeClass(' sidenav-toggled ');
			$('.app').addClass(' sidenav-toggled1 ');
		}
		else {
			$('.app').addClass(' sidenav-toggled ');
			$('.app').removeClass(' sidenav-toggled1 ');
		}
	})

})();
