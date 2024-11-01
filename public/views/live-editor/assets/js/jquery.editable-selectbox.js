/**
 * Simple Editable SelectBox (Combobox)
 * http://wpmount.com
 * 2015 (c) WPMount
 * MIT License
 */

(function () {

	$(function () {


		$.fn.editableSelectbox = function() {

			$('select',this).change(function (){
				var parentWrapper=$(this).parent();
				$('input[type=text]',parentWrapper).val($(this).val());
			});

			return this;

		};


	});

}(jQuery));