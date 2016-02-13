/*global
document: false,
console: false,
alert: false
*/
(function(NS, $, mzr) {
	"use strict";
	/**
	 * [ Class Carousel - factory used for carousel generation]
	 *
	 * @param  {[type]} onSectionReached [description]
	 */
	$.fn.carousel = function(properties) {
		return this.each(function() {
			var $this = $(this),
				carousel = NS.Carousel.init(this, properties);

			carousel.find('.arrow.left').on('click', function(e) {
				e.preventDefault();
				carousel.trigger(NS.Carousel.EVENTS.onPreviousRequested);
			});
			carousel.find('.arrow.right').on('click', function(e) {
				e.preventDefault();
				carousel.trigger(NS.Carousel.EVENTS.onNextRequested);
			});

			return carousel;
		});
	};

	$.fn.grid = function() {
		return this.each(function() {
			var $this = $(this),
				grid = NS.Grid.init(this);

			grid.find('.paginator').on('click', 'a', function(e) {
				e.preventDefault();
				grid.trigger(NS.Grid.EVENTS.onCommand, [this.href.split('#')[1]]);
			}).toggleableList();


			return grid;
		});
	};

	$.fn.toggleableList = function(options) {
		var INSTANCE = 'instance',
			DEFAULT_OPTIONS = {
				className: 'current',
				selector: 'a',
				events: 'click'
			};

		return this.each(function() {
			var $this = $(this),
				elemOptions = $.extend({}, DEFAULT_OPTIONS, options);

			$this.on(elemOptions.events, elemOptions.selector, function(e) {
				var instance = $this.data(INSTANCE) || $this.find('.' + elemOptions.className);

				if(instance) {
					instance.removeClass(elemOptions.className);
				}

				$this.data(INSTANCE, $(this).addClass(elemOptions.className));
			});
		});
	};

	$.fn.toggleVisibility = function() {
		return this.each(function() {
			return new NS.ToggleVisibility( this );
		});
	};


	$.fn.ytPlayer = function( options ) {
		return this.each(function() {
			return new NS.YTPlayer( this, options );
		});
	};

	$.fn.contentAligner = function(options) {
		return this.each(function() {
			return new NS.ContentAligner( this, options );
		});
	};

}(window.Centro, window.jQuery, window.Modernizr));

$(function() {
	$('.carousel').carousel();
	//$('.thumbnail-grid').grid();
	$('.offices-location').toggleableList({
		selector: '.grid-item h4 a'
	});

	//	accordion
	var listas = document.querySelectorAll(".dl_list"),
		newList;
	for (var i = 0; i < listas.length; i++){
		newList = new Centro.Acordeon(listas[i]);
	}

	// 2. This code loads the IFrame Player API code asynchronously.
	var tag = document.createElement('script');
	tag.src = "//www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	window.onYouTubeIframeAPIReady = function () {
		$('.yt-video-player').ytPlayer();
	};

	//	share
	$('.share').toggleVisibility();
	//	align home > middle section titles
	$('.home-content').contentAligner({
		items: '.grid-item>a'
	});

	//	grid (modal)
	$('.thumbnail-grid').on(Centro.Grid.EVENTS.onClicked, function(e, data) {
		var $modalBox = $('.modal-box');
		$modalBox.find('.modal-title').html(data.linkContent);
		$modalBox.find('.modal-subtitle').html(data.title);
		$modalBox.find('.modal-text').html(data.bio);
		Centro.Modal.show('.modal-box');
	});

	$('.is-modal').on('click', function (e) {
		e.preventDefault();
		var $modalBox = $('.modal-box');
		var $gridItem = $(this).find('figure');
		$modalBox.find('.modal-title').html($gridItem.find("h4").html());
		$modalBox.find('.modal-subtitle').html($gridItem.find("a").html());
		$modalBox.find('.modal-text').html($gridItem.find(".post-content").html());
		Centro.Modal.show('.modal-box');
	});

	//	page creatives
	$(".filter").change(function () {
		document.location = this.options[this.selectedIndex].value;
	});


	var referrerURL = (document.referrer) ? document.referrer : 'No referrer';
	$('input[name=leadsource]').val(referrerURL);

	//	comments form
	var errorContainer = $("<div class='form-error'>* Please fill out the required fields</div>").prependTo(".form-submit").hide();
	var errorLabelContainer = $("<div class='form-error'></div>").prependTo(".form-submit").hide();
	$("#commentform").validate({
		rules: {
			author: "required",
			email: {
				required: true,
				email: true
			},
			url: "url",
			comment: "required"
		},
		errorContainer: errorContainer,
		errorLabelContainer: errorLabelContainer,
		ignore: ":hidden"
	});
	$.validator.messages.required = "";
	$.validator.messages.email = "&raquo; " + $.validator.messages.email;
	$.validator.messages.url = "&raquo; " + $.validator.messages.url;
});