/**
 * vsHelper object
 * contains all helper properties, methods and options
 */


(function () {

	$(function () {
		/*
		 * Define global object - vsHelper
		 */
		vsHelper = {

			/* PROPERTIES */


			/* Path to wp-ajax file and nonce
			 * url - path to the wp-ajax file
			 * nonce - vstyler_ajax_request
			 */
			wpAjax:{},

			/* Preloader selector */
			selectorPreloader:$('#vs-preloader'),

			/* iFrame Inline CSS Selector */
			selectorInlineCSS: $('#visual-styler-plugin-styles-inline-css'),

			/* METHODS */

			updateInlineCSS: function(){
				// vsHelper object
				var $this = this;

				$.ajax({
					data: {
						action: 'vstyler_ajax_request',
						action_type: 'update_inline_css',
						nonce: $this.wpAjax.nonce
					},
					type: 'post',
					dataType: 'json',
					url:$this.wpAjax.ajaxURL,
					success: function(response) {
						if($.isEmptyObject(response.data)!==true) {
							var iFrameElement = $('#vstyler-live #vstyler-live-iframe');
							$('#visual-styler-plugin-styles-inline-css',iFrameElement.contents()).html(response.data);
						}


					},
					error   : function( xhr, err ) {
						// Log errors if AJAX call is failed
						//	console.log(xhr);
						//	console.log(err);
					}
				});
			}


		}
	});

}(jQuery));  