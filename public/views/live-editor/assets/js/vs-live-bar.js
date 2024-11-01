/**
 * vsLiveBar object
 * contains all properties, methods and options of Visual Styler Live Bar
 */


(function () {

	$(function () {
		/*
		 * Define global object - vsLiveBar
		 */
		vsLiveBar = {

			/* PROPERTIES */

			/* HTML selector of the Live Bar navigation */
			selectorNav : $('#vstyler-live-bar .vstyler-live-bar-nav>.live-bar-nav-item'),
			/* HTML selector of the Live Bar content */
			selectorContent : $('#vstyler-live-bar .vstyler-live-bar-content'),

			/* Live Bar OPTIONS panel */
			/* HTML selector of the options buttons */
			optionsSelector : $('#vstyler-live-bar #vstyler-window-options .nav-item[data-vstyler-screen]'),

			/* HTML selector of the FullScreen mode button */
			optionsFullScreenSelector: $('#vstyler-live-bar #vstyler-window-options .nav-item[data-vstyler-screen="fullscreen"]'),
			/*
			 * FullScreen mode state
			 * (bool) true or false
			 */
			optionsIsFullScreen: false,

			/*
			 * WATCHER for the current iframe size
			 * (string) mobile, tablet or desktop
			 */
			optionsScreenSize: 'desktop',


			/*
			 * WATCHER for current active Live Bar element
			 * (object)
			 */
			currentPanel : '',

			/*
			 * Current state of Live Bar
			 *  True or False
			 * !IMPORTANT! : To change this attribute use function 'changeState'
			 */
			isActive: false,

			/* METHODS */
			/*
			 * Change 'vsLiveBar'
			 *
			 * param (bool) state: state to switch (true or false)
			 * If not passed - state will be toggled (eg from true to false)
			 */
			changeState: function(state){
				// vsElementChooser object
				var $this = this;
				var state = typeof state !== 'undefined' ? state : '';

				if(state!==''){
					$this.isActive = state;
				}else {
					$this.isActive = ($this.isActive===true)?false:true;
				}

				/* PSEUDO WATCHER */
				var isActive=$this.isActive;
				var currentPanel=$($this.currentPanel);
				var panelContent=currentPanel.data('vstyler-content');


				switch (isActive){
					case true:

						$('#'+(panelContent)).slideDown();
						currentPanel.addClass('active');
						vsElementChooser.changeState(false);

						if(panelContent=='vstyler-window-history'){
							vsHistory.changeState(true);
						}
						break;
					case false:

						$this.selectorNav.removeClass('active');
						$this.selectorContent.slideUp();
						if(panelContent=='vstyler-window-history'){
							vsHistory.changeState(false);
						}
						break;

				}
				/* END PSEUDO WATCHER */

				return true;
			},

			/*
			 * Handle FullScreen Mode
			 */
			handleFullScreenMode : function(){
				var i = document.getElementById('vstyler-live');
				if(vsLiveBar.optionsIsFullScreen) {
					// exit full-screen
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.webkitExitFullscreen) {
						document.webkitExitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
					} else if (document.msExitFullscreen) {
						document.msExitFullscreen();
					}
				}else {
					// go full-screen
					if (i.requestFullscreen) {
						i.requestFullscreen();
					} else if (i.webkitRequestFullscreen) {
						i.webkitRequestFullscreen();
					} else if (i.mozRequestFullScreen) {
						i.mozRequestFullScreen();
					} else if (i.msRequestFullscreen) {
						i.msRequestFullscreen();
					}
				}
			},

			/*
			 * FullScreen Mode Listener
			 */

			listenerFullScreen: function(){
				vsLiveBar.optionsIsFullScreen=(vsLiveBar.optionsIsFullScreen===false)?true:false;
				vsLiveBar.optionsFullScreenSelector.toggleClass('vs-icon-expand vs-icon-compress active');
			}


		}

	});

}(jQuery));  