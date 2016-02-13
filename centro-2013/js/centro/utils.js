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