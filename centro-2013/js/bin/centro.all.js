/**
 * @version Feb-2013
 */
window.Centro = {
	version: '1.0'
};
// Avoid `console` errors in browsers that lack a console.
(function(NS) {
	NS.Utils = (function() {
		function toHyphenated(str) {
			var hyphenStr = '';

			str = str || hyphenStr;
			hyphenStr = str.replace(/([A-Z])/g, function(str, m1) {
				return '-' + m1.toLowerCase();
			}).replace(/^ms-/, '-ms-');

			return hyphenStr;
		}

		(function() {
			var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'],
				noop = function() {},
				length = methods.length,
				method;

			window.console = window.console || {};

			while(length--) {
				method = methods[length];

				// Only stub undefined methods.
				if(!window.console[method]) {
					window.console[method] = noop;
				}
			}
		}());

		return {
			toHyphenated: toHyphenated
		};
	}());


}(window.Centro));

function resizeFrame(height, scrollToTop) {
    if (scrollToTop) window.scrollTo(0, 0);
    var oFrame = document.getElementById('jobviteframe');
    if (oFrame) oFrame.height = height;
}

if(!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g,'');
  };
}
/**
 * @fileoverview Modal component
 * @version 1.0.0
 * @author jandrade
 *
 * TODO:
 *
 * DEPENDENCIES:
 * None
 *
 */

/*global
document: false,
console: false,
Centro: false
*/

(function (NS, $) {
	'use strict';
	
	/**
	 * Modal component functionality
	 * @class
	 * @return {Object.<function>} Module exposed methods
	 */
	NS.Modal = (function () {

		/**
		 * Close Button
		 * @type {HTMLElement}
		 * @private
		 */
		var _closeBtn,

		/**
		 * Modal DOM wrapper
		 * @type {HTMLElement}
		 * @private
		 */
			_modal,

		/**
		 * Content DOM wrapper
		 * @type {HTMLElement}
		 * @private
		 */
			_content,

		/**
		 * Close function
		 */
			_closeCallback,

		/**
		 * Default options
		 * @type {Object}
		 */
			SETTINGS = {
				close: '.close-btn',
				modal: '.modal'
			};

		/**
		 * Add modal event listeners
		 */
		function addEventListeners() {
			$(_closeBtn).on('click', closeClickHandler);
			$(document).on('keydown', keydownHandler);
		}

		/**
		 * Remove previous added listeners
		 */
		function removeEventListeners() {
			$(_closeBtn).off('click', closeClickHandler);
			$(document).off('keydown', keydownHandler);
		}

		/**
		 * Close button clicked
		 *
		 * @event
		 */
		function closeClickHandler(e) {
			hide();

			return false;
		}

		/**
		 * ESC key pressed
		 *
		 * @event
		 */
		function keydownHandler(e) {
			if (e.keyCode === 27) {
				hide();
			}
		}

		/**
		 * Shows the modal
		 * @param  {String} contentSelector The content to be shown
		 * @param  {Function} hideCallback    Callback fired when the user closes the modal
		 */
		function show(contentSelector, hideCallback) {
			_closeCallback = hideCallback || undefined;
			
			//	show overlay
			_modal.classList.add('is-open');

			_content = document.querySelector(contentSelector);
			_content.style.display = 'block';
			_content.style.marginLeft = -$(_content).width() * 0.5 + 'px';
			_content.style.marginTop = -$(_content).height() * 0.5 + 'px';

			_closeBtn = _content.querySelector(SETTINGS.close);
			addEventListeners();
		}

		function hide() {
			_content.style.display = 'none';
			_modal.classList.remove('is-open');

			removeEventListeners();

			if (typeof _closeCallback === 'function') {
				_closeCallback(_content);
			}
		}

		/**
		 * @constructor
		 */
		(function () {
			_modal = document.querySelector(SETTINGS.modal);
		}());
		
		
		return {
			show: show,
			hide: hide
		};
		
	}());

}( (window.Centro = window.Centro || {}), window.jQuery ));
/*global
document: false,
YT: false,
_gaq: false
*/
(function(NS, $, mzr) {
	"use strict";
	NS.Carousel = (function() {
		var INSTANCE_NAME = 'Carousel',
			RESIZE_DELAY = 100,
			CLASSES = {
				item: 'item',
				itemList: 'container'
			},
			DEFAULT_VALS = {
				transitionTime: 400,
				delay: 5000,
				autoplay: true
			},
			EVENTS = {
				onPreviousRequested: 'onPreviousRequested',
				onNextRequested: 'onNextRequested',
				onImgsLoaded: 'onImgsLoaded'
			},
			stepSize = 0,
			currentIndex = 0,
			autoplayInterval,
			resizeTimeout = 0,
			$itemList, $items, $element;

		function init(element, _properties) {
			$.extend(DEFAULT_VALS, _properties);
			setElement(element, DEFAULT_VALS.transitionTime);
			setInternalBindings();

			if (DEFAULT_VALS.autoplay) {
				autoplayInterval = setInterval(autoplayRequested, DEFAULT_VALS.delay);
			}

			return $element;
		}

		function setElement(element, ms) {
			$element = $(element);
			$element.data(INSTANCE_NAME, $element);
			$itemList = $element.find('.' + CLASSES.itemList);
			$itemList.css(getTransitionExp(ms));
			$items = $itemList.find('.' + CLASSES.item);
			updateWidth();
		}

		function updateWidth() {
			stepSize = $element.width();
			$items.width(stepSize);
			$itemList.width(stepSize * $items.length);
			goToSlide(currentIndex);
			resizeTimeout = 0;
		}

		function onWindowResize() {
			if(!resizeTimeout) {
				resizeTimeout = setTimeout(updateWidth, RESIZE_DELAY);
			}
		}

		function getTransitionExp(ms) {
			var attr = {},
				label = NS.Utils.toHyphenated(mzr.prefixed('transition'));

			attr[label] = 'all ' + ms + 'ms ease-out';

			return attr;
		}

		function getTranslateExp(x, y, z) {
			var attr = {},
				label = NS.Utils.toHyphenated(mzr.prefixed('transform'));

			attr[label] = 'translate3d(' + (x || 0) + 'px,' + (y || 0) + 'px,' + (z || 0) + 'px)';

			return attr;
		}

		function setInternalBindings() {
			$element.on(EVENTS.onPreviousRequested, onPreviousRequested);
			$element.on(EVENTS.onNextRequested, onNextRequested);
			// liquid update
			$(window).resize(onWindowResize);
		}

		function checkInterval() {
			if (typeof autoplayInterval !== 'undefined') {
				clearInterval(autoplayInterval);
			}
		}

		function onPreviousRequested() {
			var len = $items.length;
			checkInterval();
			currentIndex = (--currentIndex + len) % len;
			goToSlide(currentIndex);
		}

		function onNextRequested() {
			currentIndex = ++currentIndex % $items.length;
			checkInterval();
			goToSlide(currentIndex);
		}

		function autoplayRequested() {
			currentIndex = ++currentIndex % $items.length;
			goToSlide(currentIndex);
		}

		function goToSlide(index) {
			//	modern browsers
			if (mzr.csstransforms3d) {
				$itemList.css(getTranslateExp(index * -stepSize));
			//	IE8 / IE9
			} else {
				$itemList.animate({'left': index * -stepSize});
			}
		}

		return {
			EVENTS: EVENTS,
			init: init
		};

	}());

	/**
	 * Grid
	 */
	NS.Grid = (function() {
		var INSTANCE_NAME = 'Grid',
			MAX_ITEMS_PER_COL = 4,
			MAX_ITEMS_PER_ROW = 3,
			MAX_PAGES = 9,
			IS_MODAL = 'board',
			EVENTS = {
				onCommand: 'onCommand',
				onClicked: 'onClicked'
			},
			DEFAULT_GRID_ELEM = {
				'linkURL': 'http://placehold.it',
				'linkContent': 'by placehold',
				'imageURL': 'http://placehold.it/230x170',
				'imageAlt': 'A placeholder',
				'title': 'Lorem ipsum dolor sit amet'
			},
			SHORTCUTS = {
				prev: gotoPrevious,
				last: gotoLast,
				first: gotoFirst,
				next: gotoNext
			},
			CLASSES = {
				content: 'content',
				paginator: 'paginator',
				pages: 'pages',
				current: 'current',
				pageGroup: ['single', 'multiple']
			},
			dataSrc = '',
			dataGridType = '',
			currentPage = 0,
			currentPaginatorPage = 0,
			$win = $(window),
			hasModal = false,
			data, info, $element, $itemsGrid, $paginator, $pages;


		//use a micro templating stuff for this

		function getGridItem(info) {
			var thumbnailClass = (dataGridType === IS_MODAL) ? 'class="is-modal"' : '',
				data = $.extend({}, DEFAULT_GRID_ELEM, info),
				thumbnail = info ? '<td><figure><a href="' + data.linkURL + '" ' + thumbnailClass + '><img src="' + data.imageURL + '" alt="' + data.imageAlt + '" width="230" height="170"></a>' + '<figcaption><h4>' + data.title + '</h4><a href="' + data.linkURL + '">' + data.linkContent + '</a></figcaption></figure></td>'
									//if no info
									: '<td class="empty"/>';

			return thumbnail;
		}

		function getPage(page) {
			var pageLink = '<li><a href="#' + (page + 1) + '">' + ((page + 1) + (currentPaginatorPage * MAX_PAGES)) + '</a></li>';

			return pageLink;
		}

		function init(element) {
			setElement(element);
			getData(dataSrc);
			setInternalBindings();

			return $element;
		}

		function setInternalBindings() {
			$element.on(EVENTS.onCommand, onCommand);
		}

		function setElement(element) {
			$element = $(element);
			$element.data(INSTANCE_NAME, $element);
			$itemsGrid = $element.find('.' + CLASSES.content);
			$paginator = $element.find('.' + CLASSES.paginator);
			$pages = $paginator.find('.' + CLASSES.pages);
			dataSrc = $element.data('src');
			dataGridType = $element.data('grid');

			hasModal = (dataGridType === IS_MODAL);

		}

		function getData(url) {
			$.ajax({
				dataType: "json",
				url: url,
				success: onDataRequested
			});
		}

		function getDataBykey(key) {
			var i = 0,
				infoFound = false,
				infoLength = info.length;

			for ( ; i < infoLength; i++ ) {
				if ( info[i].linkURL === key ) {
					infoFound = info[i];
					break;
				}
			}

			return infoFound;
		}

		function onCommand(event, command) {
			if(data.length) {
				if(!isNaN(+command)) {
					updateGrid(+command - 1);

				} else if(SHORTCUTS[command]) {
					if(SHORTCUTS[command].call) {
						SHORTCUTS[command]();
					}
				}
			} else {
				return;
			}
		}

		function onDataRequested(response) {
			var page = [];

			data = [];
			info = [].concat(response.data);

			while(response.data.length) {
				page.push(response.data.splice(0, MAX_ITEMS_PER_COL * MAX_ITEMS_PER_ROW));

				if(page.length === MAX_PAGES) {
					data.push(page);
					page = [];
				}
			}

			if(page.length > 0) {
				data.push(page);
			}

			if (page.length > 1) {
				setPaginatorNavigation();
				updatePaginator();
			}

			updateCurrentPage(0);
			updateGrid(0);
		}

		function onItemClicked(e) {
			var link = (e.currentTarget) ? e.currentTarget : e.srcElement,
				linkValues = link.href.split('/'),
				key = linkValues[linkValues.length-1];

			$element.trigger(NS.Grid.EVENTS.onClicked, [getDataBykey(key)]);

			return false;
		}

		function setPaginatorNavigation() {
			var lastIndex = data.length - CLASSES.pageGroup.length;

			$paginator.addClass((lastIndex < 0) ? '' : CLASSES.pageGroup[lastIndex > 1 ? 1 : lastIndex]);
		}

		function updateGrid(page) {
			var currentPage = [].concat(data[currentPaginatorPage][page]),
				len = currentPage.length - (currentPage.length % MAX_ITEMS_PER_ROW),
				responseStr = '<tr>',
				i = 0;

			len += (len < currentPage.length) ? MAX_ITEMS_PER_ROW : 0;

			for(i = 0; i < len; i++) {
				responseStr += ((i % MAX_ITEMS_PER_ROW === 0) && (i > 0) ? '</tr><tr>' : '') + getGridItem(currentPage.shift());
			}

			responseStr += '</tr>';
			$itemsGrid.html(responseStr);

			if (hasModal) {
				$itemsGrid.find('a').on('click', onItemClicked);
			}

			updateCurrentPage(page);
		}


		function updatePaginator() {
			var len = Math.min(data[currentPaginatorPage].length, MAX_PAGES),
				responseStr = '',
				i = 0;

			for(i = 0; i < len; i++) {
				responseStr += getPage(i);
			}

			$pages.html(responseStr);
		}

		function updateCurrentPage(page) {
			var children = $pages.children();

			currentPage = isNaN(page) ? currentPage : page;
		}

		function gotoPaginatorPage(page) {
			if(page !== currentPaginatorPage) {
				currentPaginatorPage = page;
				updatePaginator();
				updateGrid(0);
			} else {
				return;
			}
		}

		function gotoPrevious() {
			gotoPaginatorPage((currentPaginatorPage > 0) ? currentPaginatorPage - 1 : 0);
		}

		function gotoLast() {
			gotoPaginatorPage(data.length - 1);
		}

		function gotoFirst() {
			gotoPaginatorPage(0);
		}

		function gotoNext() {
			var lastIndex = data.length - 1;

			gotoPaginatorPage((currentPaginatorPage < lastIndex) ? currentPaginatorPage + 1 : lastIndex);
		}

		return {
			EVENTS: EVENTS,
			init: init,
			onCommand: onCommand
		};
	}());

	NS.Acordeon = function(id, options){
		var element = id,
			settings = {
				linkClass:".dl_link",
				list:".dl_drawer"
			},
			linkBtn,
			list;

		function show() {
			element.classList.add("open");
			element.classList.remove("close");
		}

		function hide() {
			element.classList.add("close");
			element.classList.remove("open");
		}

		function clickHandler(e) {
			e.preventDefault();
			if (element.classList.contains("open")) {
				hide();
			}else{
				show();
			}
		}

		(function(){
			settings = $.extend(settings,options);
			linkBtn = element.querySelector(settings.linkClass);
			list = element.querySelector(settings.list);

			$(linkBtn).on('click', clickHandler);
		}());
	};

	/**
	 * @class Search form functionality
	 * @param  {HTMLElement} el Search form element
	 * @param  {Object} options		Module settings
	 * @return {Object}             Exposed methods
	 */
	NS.Search = (function (el, options) {

		var element,
			searchInput,
			/**
			 * Default settings
			 * @type {Object}
			 */
			SETTINGS = {
				searchInput: '#s'
			};

		/**
		 * @constructor
		 */
		(function () {
			element = document.querySelector(el);

			$('input, textarea').placeholder();

			searchInput = element.querySelector(SETTINGS.searchInput);
			//	initialize value
			searchInput.value = '';

			$(element).submit( element_submitHandler );
		}());

		/**
		 * Checks if the form inputs are valid
		 * @return {Boolean} Form OK
		 */
		function validateForm() {
			var keyword = searchInput.value.trim();
			return keyword.length > 0;
		}

		/**
		 * Filter form submission
		 * @return {Boolean}   Valid form?
		 */
		function element_submitHandler(e) {
			var isValid = validateForm();
			//	trim value
			if (isValid) {
				searchInput.value = searchInput.value.trim();
			}

			return isValid;
		}

		return {};

	}('.search-form'));

	/**
	 * @class Show / hide a selected container
	 * @param  {HTMLElement} el Module main element
	 * @param  {Object} options		Module settings
	 * @return {Object}             Exposed methods
	 */
	NS.ToggleVisibility = (function (el, options) {

		var element,
		toggleBtn,
			container,
			/**
			 * Default settings
			 * @type {Object}
			 */
			SETTINGS = {
				toggleBtn: 'summary a',
				container: '.share-content',
				toggleClass: 'open'
			};

		/**
		 * @constructor
		 */
		(function () {
			element = (typeof el === 'string') ? document.querySelector(el) : el;
			toggleBtn = element.querySelector(SETTINGS.toggleBtn);
			container = element.querySelector(SETTINGS.container);

			$(toggleBtn).on('click', toggleBtn_clickHandler );
		}());

		/**
		 * Filter form submission
		 * @return {Boolean}   Valid form?
		 */
		function toggleBtn_clickHandler(e) {
			container.classList.toggle(SETTINGS.toggleClass);

			return false;
		}

		return {};

	});

	/**
	 * @class Custom play button for youtube videos
	 * Uses the youtube iframe API
	 * @param  {HTMLElement} element Module main element
	 * @param  {Object} options		Module settings
	 * @return {Object}             Exposed methods
	 */
	NS.YTPlayer = function(element, options) {
		var _player,
			_thumbnail,
			_$playButton,
			_$element = $(element),
			firstPlay = true,
			SETTINGS = {
				id: 'video-player',
				key: '',
				playButton: '.video-player-button',
				thumbnail: 'figure',
				height: '200',
				width: '260',
				name:""
			},
			EVENT = {
				category: 'test',
				action: 'View',
				label: 'Homepage'
			};

		function _init() {
			SETTINGS = $.extend(SETTINGS, options);

			SETTINGS.id = 'video-player-' + _$element[0].getAttribute("data-yt-id");
			SETTINGS.key = _$element[0].getAttribute("data-yt-key");

			_player = new YT.Player(SETTINGS.id, {
				height: SETTINGS.height,
				width: SETTINGS.width,
				playerVars: {
					enablejsapi: 0,
					autohide: 2,
					autoplay: 0,
					controls: 1,
					showinfo: 0,
					wmode: 'transparent',
				color: 'white'
				},
				videoId: SETTINGS.key,
				events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
				}
			});

			_$playButton = _$element.find(SETTINGS.playButton);
			_thumbnail = _$element.find(SETTINGS.thumbnail);

			EVENT.category = _$playButton[0].getAttribute("data-event-category");
			EVENT.action = _$playButton[0].getAttribute("data-event-action");
			EVENT.label = _$playButton[0].getAttribute("data-event-label");
		}

		function playVideo(e) {
			e.preventDefault();
			hideControls();
			_player.playVideo();

			if (firstPlay) {
				firstPlay = false;
				trackEvent();
			}
		}

		function trackEvent() {
			_gaq.push(['_trackEvent',EVENT.category, EVENT.action, EVENT.label]);
		}

		/**
		 * Player ready
		 * @event
		 */
		function onPlayerReady(e) {
			showControls();

			_$playButton.bind("click", playVideo);
        }

		/**
		 * Video state changed
		 * @event
		 */
		function onPlayerStateChange(event) {
			//	pause video
			if (event.data == YT.PlayerState.PAUSED) {
				showControls();
			}
			//	play video
			if (event.data == YT.PlayerState.PLAYING) {
				hideControls();
			}
		}

		function showControls() {
			_$playButton.fadeIn();
			_thumbnail.fadeIn();
		}

		function hideControls() {
			_$playButton.fadeOut();
			_thumbnail.fadeOut();
		}

		function stopVideo() {
			_player.stopVideo();
		}

		/**
		 * @constructor
		 */
		(function () {
			_init();
		})();
	};

	/**
	 * @class Aligns a set of contents (titles, paragraphs, etc.) that are located on the same level
	 * @param  {HTMLElement} el Module main element
	 * @param  {Object} options		Module settings
	 * @return {Object}             Exposed methods
	 */
	NS.ContentAligner = (function (el, options) {
		var element,
			items,
			SETTINGS = {
				items: 'a'
			};

		/**
		 * @constructor
		 */
		(function () {
			SETTINGS = $.extend(SETTINGS, options);

			element = (typeof el === 'string') ? document.querySelector(el) : el;
			items = element.querySelectorAll(SETTINGS.items);

			init();

		}());

		/**
		 * Initialize component
		 */
		function init () {
			var i = 0,
				itemsLength = items.length,
				itemHeight,
				maxHeight = 0;

			//	get max height
			for ( ; i < itemsLength; i++ ) {
				itemHeight = $(items[i]).height();
				if ( itemHeight > maxHeight ) {
					maxHeight = itemHeight;
				}
			}
			//	set max height for all contents
			$(items).height(maxHeight);
		}
	});

}(window.Centro, window.jQuery, window.Modernizr));
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