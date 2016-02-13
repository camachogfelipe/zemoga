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