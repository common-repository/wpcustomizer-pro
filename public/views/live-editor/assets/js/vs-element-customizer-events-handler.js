/**
 * VS Element Customizer Events and Fields handler
 */

(function () {
	'use strict';
	$(function () {


		/*
		 * ELEMENT CUSTOMIZER EVENTS
		 * -----------------------------------------------------------------------------------------------------
		 */

		/*
		 * Element Customizer Watchers
		 */

		// isActive watcher
		watch(vsElementCustomizer,'isActive',function(){
			var isActive=vsElementCustomizer.isActive;
			switch (isActive){
				case true:
					vsElementCustomizer.init();
					break;
				case false:
					vsElementCustomizer.destroy();
					break;
			}
		});

		// Element final CSS Code watcher
		watch(vsElementCustomizer,['elementCSSCode','elementSelector','elementSelectorState','elementSelectorBreakpoint'],function(){
			var iFrameElement = $('#vstyler-live #vstyler-live-iframe');
			var state=vsElementCustomizer.elementSelectorState?':'+vsElementCustomizer.elementSelectorState:'';
			var breakPoints=vsElementCustomizer.elementSelectorBreakpoint;
			var breakPointStart='';
			var breakPointEnd='';
			switch(breakPoints){
				case 'mobile':
					breakPointStart='@media only screen and (max-width : 480px) {';
					breakPointEnd='}';
					break;
				case 'tablet':
					breakPointStart='@media only screen and (min-width : 481px) and (max-width : 992px) {';
					breakPointEnd='}';
					break;
				case 'desktop':
					breakPointStart='@media only screen and (min-width : 1200px) {';
					breakPointEnd='}';
					break;

			}
			var finalCode=breakPointStart+vsElementCustomizer.elementSelector+state+'{'+vsElementCustomizer.elementCSSCode+'}'+breakPointEnd;
			$('#vstyler-css-preview',iFrameElement.contents()).html(finalCode);
			$('#customizer-css-code').html(finalCode);
		});

		/*
		 * Element Customizer Options Panel
		 */
		vsElementCustomizer.selectorOptionsPanel.on('click', function (event) {
			event.preventDefault();
			var navRole=$(this).data('vstyler-role');
			switch (navRole){
				case 'changeState':
					if(vsElementCustomizer.elementSelectorState=='') {
						vsElementCustomizer.elementSelectorState = 'hover';
					}else{
						vsElementCustomizer.elementSelectorState = '';
					}
					$(this).toggleClass('active');
					break;
				case 'changeBreakPoint':
					var screenMode=$(this).data('vstyler-screen');
					if(vsElementCustomizer.elementSelectorBreakpoint!=screenMode) {
						vsElementCustomizer.elementSelectorBreakpoint = screenMode;
						$(this).closest('.customizer-options-nav').find('.nav-item').not(this).removeClass('active');
					}else{
						vsElementCustomizer.elementSelectorBreakpoint = '';
					}
					$(this).toggleClass('active');
					break;
				case 'showCode':
					vsElementCustomizer.showFinalCSSCode();
					$(this).toggleClass('active');
					break;
				case 'saveCode':

					vsElementCustomizer.saveFinalCSSCode();
					break;
			}
		});

		/*
		 * Element Customizer Element Path Handler
		 */
		vsElementCustomizer.selectorElementPath.on('change','input[type=checkbox]',function(event){
			vsElementCustomizer.getFinalElementSelector();
		});

		/*
		 * Element Customizer CSS Options Tabs
		 */
		vsElementCustomizer.selectorCSSOptionsTabs.on( 'click', function( event ){
			event.preventDefault();
			vsElementCustomizer.hideCSSOptionsTab();
			vsElementCustomizer.displayCSSOptionsTab($(this));
		});


		/*
		 * ELEMENT CUSTOMIZER FIELDS
		 * -----------------------------------------------------------------------------------------------------
		 */

		/* COLORPICKER */

		$('.field-colorpicker').iris({
			hide: false,
			change: function(event, ui) {
				// event = standard jQuery event, produced by whichever control was changed.
				// ui = standard jQuery UI object, with a color member containing a Color.js object
				// change the headline color
				$(this).css( 'border-color', ui.color);
			}
		});


		$(document).click(function (e) {
			if (!$(e.target).is(".field-colorpicker, .iris-picker, .iris-picker-inner")) {
				$('.field-colorpicker').iris('hide');
			}
		});
		$('.field-colorpicker').click(function (event) {
			$('.field-colorpicker').iris('hide');
			$(this).iris('show');
			return false;
		});

		/* END COLORPICKER */


		/* COMBOBOX */

		$('.field-combobox-wrapper').editableSelectbox();

		/* END COMBOBOX */


		/* SLIDER */

		$('.field-slider-wrapper>.field-slider-box').slider({
			range: "min",
			value: 1,
			min: 0,
			max: 99,
			step: 1,
			slide: function(event, ui) {
				$('.field-slider',$(this).parent()).val(ui.value+'px');
			}
		});

		/* END SLIDER */


		/* IMAGE UPLOADER */


		//Handle Uploader iFrame
		var iFrameUploader = $('#vstyler-media-iframe-wrapper #vstyler-media-iframe');

		iFrameUploader.on('load', function(){

			iFrameUploader.contents().on('click','.savesend>.button', function(event){

				event.preventDefault();
				var optionName=iFrameUploader.data('css-option-name');
				var formHTML=this.closest('form');
				var imageURL = $('.button.urlfile',formHTML).data('link-url');

				$('#'+optionName).val("url('"+imageURL+"')");
				iFrameUploader.data('css-option-name','');
				// Reset Media Uploader URL
				var iFrameUploaderURL=iFrameUploader.data('media-uploader-url');
				iFrameUploader.attr('src',iFrameUploaderURL);
				$('#vstyler-media-iframe-wrapper').hide();
				return false;
			});
		});

		$('.upload-image-button').on('click',function() {
			iFrameUploader.data('css-option-name',$('input[type=text]',$(this).parent()).attr('name'));
			$('#vstyler-media-iframe-wrapper').toggle();
			return false;
		});

		// Close Media Uploader
		$('#vstyler-media-iframe-wrapper, #vstyler-close-iframe').on('click',function(event) {
			event.preventDefault();
			iFrameUploader.data('css-option-name','');
			// Reset Media Uploader URL
			var iFrameUploaderURL=iFrameUploader.data('media-uploader-url');
			iFrameUploader.attr('src',iFrameUploaderURL);
			$('#vstyler-media-iframe-wrapper').hide();
			return false;
		});

		/* END IMAGE UPLOADER */


		/* FIELDS ON CHANGE HANDLER */
		$.each(vsElementCustomizer.CSSProperties, function(iTab, tabObject) {

			$.each(tabObject, function(iProperty,CSSProperty){
				var CSSPropertyName=CSSProperty.name;
				vsElementCustomizer.watchProperty(document.getElementById(CSSPropertyName),'value',function(){
					var newValue=$(this).val();
					if(vsElementCustomizer.originalCSSValues[CSSPropertyName]!==newValue){
						vsElementCustomizer.newCSSValues[CSSPropertyName]=newValue;
					}else{
						delete vsElementCustomizer.newCSSValues[CSSPropertyName];
					}
					vsElementCustomizer.updateElementCSSCode()
				});
			});
		});
		/* END FIELDS ON CHANGE HANDLER */


	});

}(jQuery));  