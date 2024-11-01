(function ( $ ) {

	"use strict";

	$(function () {


		$(window).load(function() {
			vsHelper.selectorPreloader.show();
			vsHelper.selectorPreloader.delay(100).fadeOut(500);
		});
		/*
		 * AJAX Preloader
		 */
		$(document).ajaxStart(function () {
			vsHelper.selectorPreloader.show();
		})
		$(document).ajaxStop(function () {
			vsHelper.selectorPreloader.hide();
		});


		/*
		 * Make live bar draggable
		 */
		$( '#vstyler-live-bar' ).draggable({
			handle: '.vstyler-live-bar-nav>.nav-drag',
			scroll: false,
			iframeFix: true,
			containment: 'parent'
		});

		/*
		 * LIVE BAR
		 */

		vsLiveBar.selectorNav.on( 'click', function( event ){
			event.preventDefault();
			if(vsLiveBar.currentPanel===event.target){
				vsLiveBar.changeState();
				vsLiveBar.currentPanel='';
			}else{
				vsLiveBar.changeState(false);
				vsLiveBar.currentPanel=event.target;
				vsLiveBar.changeState(true);
			}
		});

		/*
		 * LIVE BAR OPTIONS
		 */

		/*
		 * Options Watchers
		 */

		/*
		 * FullScreen mode eventListeners
		 */

		document.addEventListener("fullscreenchange", function () {
			vsLiveBar.listenerFullScreen();
		});
		document.addEventListener("webkitfullscreenchange", function () {
			vsLiveBar.listenerFullScreen();
		});
		document.addEventListener("mozfullscreenchange", function () {
			vsLiveBar.listenerFullScreen();
		});
		document.addEventListener("MSFullscreenChange", function () {
			vsLiveBar.listenerFullScreen();
		});

		/*
		 * Screen mode watcher
		 */
		watch(vsLiveBar,'optionsScreenSize',function(){
			var screenSize=vsLiveBar.optionsScreenSize;
			var iFrameWrapper=$('#vstyler-live-iframe-wrapper');

			iFrameWrapper.removeClass('screen-mobile screen-tablet');
			switch (screenSize){
				case 'mobile':
					iFrameWrapper.addClass('screen-mobile');
					break;
				case 'tablet':
					iFrameWrapper.addClass('screen-tablet');
					break;
				case 'desktop':
					iFrameWrapper.removeClass('screen-mobile screen-tablet');
					break
			}
		});

		/*
		 * Screen modes
		 */
			vsLiveBar.optionsSelector.on('click', function (event) {
				event.preventDefault();
				var screenMode=$(this).data('vstyler-screen');

				if(screenMode=='fullscreen'){
					vsLiveBar.handleFullScreenMode();
				}else{
					vsLiveBar.optionsScreenSize=screenMode;
					vsLiveBar.optionsSelector.not("[data-vstyler-screen='fullscreen']").removeClass('active');
					$(this).addClass('active');

				}

			});




		/*
		 * ELEMENT CHOOSER
		 */

		/*
		 * Element Chooser Watchers
		 */

		// isActive watcher
		watch(vsElementChooser,'isActive', function () {
			var isActive=vsElementChooser.isActive;
			vsElementCustomizer.changeState(false);
			vsElementChooser.hideElementPathLabel();
			vsElementChooser.selector.toggleClass('vs-icon-location-arrow vs-icon-ban active');

			switch (isActive){
				case true:
					break;
				case false:
					$(vsElementChooser.currentElement).css(vsElementChooser.options.styles.targetMouseOut);
					vsElementChooser.isCurrentElementSelected=false;
					break;
			}
		});

		// currentElement watcher
		watch(vsElementChooser,'currentElement', function () {
			if(vsElementChooser.isActive!==true){return false;}
			if(vsElementChooser.isCurrentElementSelected!==false){return false;}

			var currentElement=vsElementChooser.currentElement;
			vsElementChooser.elementPathValue=vsElementChooser.getElementPath({
				element: currentElement,
				//	deep: 3,
				details: 'full'
				//		separator: ' > '//,
				//ignoreElement: true
			});
		});

		// isCurrentElementSelected watcher
		watch(vsElementChooser,'isCurrentElementSelected', function () {
			var isCurrentElementSelected=vsElementChooser.isCurrentElementSelected;
		//	vsElementChooser.selector.toggleClass('vs-icon-location-arrow vs-icon-ban active');
			switch (isCurrentElementSelected){
				case true:
					vsElementChooser.hideElementPathLabel();
					vsElementCustomizer.changeState(true);
					break;
				case false:
					vsElementCustomizer.changeState(false);
					break;
			}
		});


		// currentElementAction watcher
		watch(vsElementChooser,'currentElementAction', function () {
			if(vsElementChooser.isActive!==true){return false;}
			if(vsElementChooser.isCurrentElementSelected!==false){return false;}

			var currentElementAction=vsElementChooser.currentElementAction;
			var currentElement=$(vsElementChooser.currentElement);
			switch (currentElementAction){
				case 'mouseover':
					currentElement.css(vsElementChooser.options.styles.targetMouseOver);
					vsElementChooser.displayElementPathLabel();
					break;
				case 'mouseout':
					currentElement.css(vsElementChooser.options.styles.targetMouseOut);
					break;
				case 'click':
					vsElementChooser.isCurrentElementSelected=true;
					break;
			}
		});

		// currentHotkey watcher
		watch(vsElementChooser,'currentHotkey', function () {
			var currentHotkey=vsElementChooser.currentHotkey;

			switch(currentHotkey){
				case 27: //ESC - exit from Element Chooser
					if(vsElementChooser.isActive===true) {
						vsElementChooser.changeState(false);
						vsElementChooser.currentHotkey=''; // reset currentHotkey
					}
					break;
				case 83: // S - select element
					// If Element Chooser is not active - activate it and allow to choose element
					if(vsElementChooser.isActive!==true) {
						vsElementChooser.changeState(true);
						vsElementChooser.currentHotkey=''; // reset currentHotkey
					}else{
						// Else - deactivate Element Chooser if 'S' has been pressed again
						vsElementChooser.currentHotkey=27;
					}
					break;
			}
		});

		// Bind hotkeys
		$(document).on('keyup', function(event){
			// Prevent Hotkeys when input or textarea are in focus
			if ($(event.target).is('input, textarea')) {
				return;
			}
			var keyCode=event.keyCode;
			vsElementChooser.currentHotkey=keyCode;

		});

		// Change state for ElementChooser when Live Editor Bar button is clicked
		vsElementChooser.selector.on( 'click', function( event ){
			event.preventDefault();
			vsLiveBar.changeState(false);
			vsElementChooser.changeState();
		});


		//Handle iFrame with main content
		var iFrameElement = $('#vstyler-live #vstyler-live-iframe');

		iFrameElement.on('load', function(){

			iFrameElement.contents().find('body').append('<style id="vstyler-css-preview"></style>');

			// Duplicate bind hotkeys within iFrame content
			iFrameElement.contents().on('keyup', function(event){
				// Prevent Hotkeys when input or textarea are in focus
				if ($(event.target).is('input, textarea')) {
					return;
				}
				var keyCode=event.keyCode;
				vsElementChooser.currentHotkey=keyCode;
			});

			iFrameElement.contents().on('mouseover', function(event){
				if(vsElementChooser.isActive!==true){return false;}
				if(vsElementChooser.isCurrentElementSelected!==false){return false;}


				vsElementChooser.currentElement= event.target;
				vsElementChooser.currentElementAction='mouseover';
			});
			iFrameElement.contents().on('mouseout', function(event){
				if(vsElementChooser.isActive!==true){return false};
				if(vsElementChooser.isCurrentElementSelected!==false){return false;}

				vsElementChooser.currentElement= event.target;
				vsElementChooser.currentElementAction='mouseout';
			});
			iFrameElement.contents().on('click', function(event){
				if(vsElementChooser.isActive!==true){return false;}
				if(vsElementChooser.isCurrentElementSelected!==false){return false;}
				event.preventDefault();

				vsElementChooser.currentElement= event.target;
				vsElementChooser.currentElementAction='click';

				return false;
			});
		});

	});

}(jQuery));