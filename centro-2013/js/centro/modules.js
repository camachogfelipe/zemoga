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