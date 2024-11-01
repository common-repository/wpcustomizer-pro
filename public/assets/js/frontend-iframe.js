(function ( $ ) {
	"use strict";

	$(function () {

		/*
		 * Get vsElementChooser global object
		 */
		var parentVsElementChooser=window.parent.vsElementChooser;
		/*
		 * Add GET params via jQuery
		 */
		function setGetParameter(url,paramName, paramValue){
			var url = typeof url !== 'undefined' ? url : window.location.href;
			var splitAtAnchor = url.split('#');
			url = splitAtAnchor[0];
			var anchor = typeof splitAtAnchor[1] === 'undefined' ? '' : '#' + splitAtAnchor[1];
			if (url.indexOf(paramName + "=") >= 0)
			{
				var prefix = url.substring(0, url.indexOf(paramName));
				var suffix = url.substring(url.indexOf(paramName));
				suffix = suffix.substring(suffix.indexOf("=") + 1);
				suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
				url = prefix + paramName + "=" + paramValue + suffix;
			}
			else
			{
				if (url.indexOf("?") < 0)
					url += "?" + paramName + "=" + paramValue;
				else
					url += "&" + paramName + "=" + paramValue;
			}
			window.location.href = url + anchor;
		}

		/*
		 * Check if Live Editor is enabled, eg: WordPress site is launched in iFrame with ID=vstyler-live-iframe
		 */
		if ((top != self) && (self.frameElement.id=='vstyler-live-iframe')){
			// Additional check for vstyler-action
			if(top.location.href.indexOf('vstyler-action=edit-page') > -1) {
				$('a').click(function (event) {

					event.preventDefault();


					var url = $(this).attr('href');
					//prevent access to wp-admin when live editor is enabled
					if(url.indexOf('wp-admin') > -1) {
						alert ('Access to WP-Admin is temporarily closed. Please first exit the Visual Styler Live Editor.');
						return true;
					}

					// prevent link clicking while choosing element
					if(parentVsElementChooser.isActive==true){
						if(parentVsElementChooser.isCurrentElementSelected!==false){
							parentVsElementChooser.currentElement=$(this);
							parentVsElementChooser.isCurrentElementSelected=true;
						}
						return true;
					}


					// hide toolbar in iframe
					setGetParameter(url, 'vstyler-action', 'hide-toolbar');

				});
				$('button, input[type=submit]').click(function(event){
					event.preventDefault();
					// prevent link clicking while choosing element
					if(parentVsElementChooser.isActive==true){
						if(parentVsElementChooser.isCurrentElementSelected!==false){
							parentVsElementChooser.currentElement=$(this);
							parentVsElementChooser.isCurrentElementSelected=true;
						}
						return true;
					}

				});
			}
		}

	});

}(jQuery));