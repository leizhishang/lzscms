;
(function($, h) {
	h.datalist = function(elem, options) {
		var _options = {
			
		}
		$.extend(true, _options, options);
		Hstui.dataTable('#list', {
			scrollY: 200,
			scrollX: true,
		}, function(t) {

		});
	}
})(jQuery, Hstui);