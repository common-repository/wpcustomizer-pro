/**
 * vsHistory Events handler
 */

(function () {
	'use strict';
	$(function () {

		/*
		 * vsHistory Watchers
		 */

		// isActive watcher
		watch(vsHistory,'isActive',function(){
			var isActive=vsHistory.isActive;

			switch (isActive){
				case true:
					vsHistory.init();
					break;
				case false:
					vsHistory.destroy();
					break;
			}
		});

		watch(vsHistory,'historyIndex',function(){
			var historyIndex=vsHistory.historyIndex;

			if(historyIndex===''){
				vsHistory.selectorHistoryDetailsNavWrapper.hide();
				vsHistory.selectorHistoryDetailsCode.val('');
				vsHistory.selectorHistoryDetailsCode.hide()
			}else{
				vsHistory.loadHistoryDetails();
				vsHistory.selectorHistoryDetailsCode.show();
				vsHistory.selectorHistoryDetailsNavWrapper.show();

			}
		});

		/*
		 * History chooser
		*/

		var historyListSelector='#vstyler-live-bar #vstyler-window-history .history-list-wrapper .history-list-container .history-list>.history-item';
		$(document).on('click', historyListSelector ,function(event){
			event.preventDefault();
			$(this).closest('.history-list').find('.history-item').not(this).removeClass('active');
			$(this).addClass('active');
			vsHistory.historyIndex=$(this).index();

		});

		/*
		 * History details nav
		 */
		$('.nav-item',vsHistory.selectorHistoryDetailsNavWrapper).on('click', function (event) {
			event.preventDefault();
			var navRole=$(this).data('vstyler-role');
			switch (navRole){

				case 'disableHistory':
					vsHistory.disableHistory();
					$(this).toggleClass('active');
					break;
				case 'updateHistory':
					vsHistory.updateHistory();
					break;
				case 'deleteHistory':
					vsHistory.deleteHistory();
					break;
			}
		});

	});

}(jQuery));  