/**
 * vsHistory object
 * contains all properties, methods and options of History feature
 */





(function () {

	$(function () {
		/*
		 * Define global object - vsHistory
		 */
		vsHistory = {

			/* PROPERTIES */

			/* HTML selector of history panel */
			selectorHistoryPanel: $('#vstyler-live-bar #vstyler-window-history'),
			/* HTML selector of history list */
			selectorHistoryList: $('#vstyler-live-bar #vstyler-window-history .history-list-wrapper .history-list-container'),
			selectorHistoryListItem: $('#vstyler-live-bar #vstyler-window-history .history-list-wrapper .history-list-container .history-list>.history-item'),
			/* HTML selector of history details nav */
			selectorHistoryDetailsNavWrapper: $('#vstyler-live-bar #vstyler-window-history .history-details-wrapper .options-panel .history-options-nav'),
			/* HTML selector of history details content */
			selectorHistoryDetailsCode: $('#vstyler-live-bar #vstyler-window-history .history-details-wrapper .history-details-content #history-details-code'),

			/*
			 * Current state of vsHistory
			 *  True or False
			 * !IMPORTANT! : To change this attribute use function 'changeState'
			 */
			isActive: false,

			/* Selected history index */
			historyIndex:'',

			historyIsActive:'',

			historyCode:'',


			/* METHODS */

			/*
			 * Initialize the vsHistory
			 */
			init: function () {
				// vsHistory object
				var $this = this;

				$this.loadHistoryList();

				$this.selectorHistoryDetailsNavWrapper.hide();
				$this.selectorHistoryDetailsCode.val('');
				$this.selectorHistoryDetailsCode.hide()
			},

			/*
			 * Destroy the vsHistory
			 */
			destroy: function () {
				// vsHistory object
				var $this = this;



				vsHistory.historyIndex='';
				vsHistory.historyIsActive='';
				vsHistory.historyCode='';



				$this.unLoadHistoryList();
			},

			/*
			 * Change 'vsHistory'
			 *
			 * param (bool) state: state to switch (true or false)
			 * If not passed - state will be toggled (eg from true to false)
			 */
			changeState: function(state){
				// vsHistory object
				var $this = this;
				var state = typeof state !== 'undefined' ? state : '';

				if(state!==''){
					$this.isActive = state;
				}else {
					$this.isActive = ($this.isActive===true)?false:true;
				}

				return true;
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Load history list
			 */
			loadHistoryList: function(){
				// vsHistory object
				var $this = this;

				$.ajax({
					data: {
						action: 'vstyler_ajax_request',
						action_type: 'get_history_list',
						nonce: vsHelper.wpAjax.nonce
					},
					type: 'post',
					dataType: 'json',
					url:vsHelper.wpAjax.ajaxURL,
					success: function(response) {
						vsHistory.selectorHistoryList.html('');
						if($.isEmptyObject(response.data)!==true) {
							var historyList = vsHistory.selectorHistoryList.append('<ul class="history-list"></ul>').find('ul');
							$.each(response.data, function (i, item) {
								historyList.append('<li class="history-item"><span class="history-date">' + item.date_updated_formatted + '</span><span class="history-date-diff">' + item.date_updated_diff + '</span></li>');
							});
						}else{
							vsHistory.selectorHistoryList.append('There is no history');
						}


					},
					error   : function( xhr, err ) {
						// Log errors if AJAX call is failed
						//	console.log(xhr);
						//	console.log(err);
					}
				});

			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Un-Load history list
			 */
			unLoadHistoryList: function(){
				// vsHistory object
				var $this = this;

				$this.selectorHistoryList.html('');
			},


			/*
			 * Load History details with History Index
			*/
			loadHistoryDetails: function(){
				// vsHistory object
				var $this = this;

				$('.nav-item[data-vstyler-role="disableHistory"]',$this.selectorHistoryDetailsNavWrapper).removeClass('active');
				$.ajax({
					data: {
						action: 'vstyler_ajax_request',
						action_type: 'get_history_details',
						nonce: vsHelper.wpAjax.nonce,
						history_index: $this.historyIndex
					},
					type: 'post',
					dataType: 'json',
					url:vsHelper.wpAjax.ajaxURL,
					success: function(response) {
						$this.historyIsActive=response.data.is_active;
						$this.historyCode=response.data.css_code;

						$($this.selectorHistoryDetailsCode).val(response.data.css_code);
						if($this.historyIsActive!==true) {
							$('.nav-item[data-vstyler-role="disableHistory"]',$this.selectorHistoryDetailsNavWrapper).addClass('active');
						}

					},
					error   : function( xhr, err ) {
						// Log errors if AJAX call is failed
						//	console.log(xhr);
						//	console.log(err);
					}
				});
			},

			/*
			 * History Details Handler: disable history
			 */
			disableHistory: function(){
				// vsHistory object
				var $this = this;

				if($.isNumeric($this.historyIndex)){
					var code = $("#history-details-code").val();
					$this.historyIsActive=$this.historyIsActive==true?false:true;
					$.ajax({
						data: {
							action: 'vstyler_ajax_request',
							action_type: 'update_css',
							nonce: vsHelper.wpAjax.nonce,
							css_code:code,
							history_index: $this.historyIndex,
							is_active: $this.historyIsActive
						},
						type: 'post',
						dataType: 'json',
						url: vsHelper.wpAjax.ajaxURL,
						success: function(response) {
						//	$this.reInitHistory();
							vsHelper.updateInlineCSS();
						},
						error   : function( xhr, err ) {
							// Log errors if AJAX call is failed
							//	console.log(xhr);
							//	console.log(err);
						}
					});

				}
			},

			/*
			 * History Details Handler: update history code
			 */
			updateHistory: function(){
				// vsHistory object
				var $this = this;

				if($.isNumeric($this.historyIndex)){
					var code = $("#history-details-code").val();
					$.ajax({
						data: {
							action: 'vstyler_ajax_request',
							action_type: 'update_css',
							nonce: vsHelper.wpAjax.nonce,
							css_code:code,
							history_index: $this.historyIndex
						},
						type: 'post',
						dataType: 'json',
						url: vsHelper.wpAjax.ajaxURL,
						success: function(response) {
						//	$this.reInitHistory();
							vsHelper.updateInlineCSS();

						},
						error   : function( xhr, err ) {
							// Log errors if AJAX call is failed
							//	console.log(xhr);
							//	console.log(err);
						}
					});
				}
			},

			/*
			 * History Details Handler: delete history
			 */
			deleteHistory: function(){
				// vsHistory object
				var $this = this;

				if($.isNumeric($this.historyIndex)) {
					if (confirm('Delete this history?')) {
						$.ajax({
							data: {
								action: 'vstyler_ajax_request',
								action_type: 'delete_history',
								nonce: vsHelper.wpAjax.nonce,
								history_index: $this.historyIndex
							},
							type: 'post',
							dataType: 'json',
							url: vsHelper.wpAjax.ajaxURL,
							success: function (response) {
								$this.reInitHistory();
							},
							error: function (xhr, err) {
								// Log errors if AJAX call is failed
								//	console.log(xhr);
								//	console.log(err);
							}
						});
					}
				}
			},

			/* ReInit history when history is changed (status/code/or history deleted) */
			reInitHistory: function(){
				// vsHistory object
				var $this = this;

				$this.destroy();
				$this.init();
				vsHelper.updateInlineCSS();

			}


		}
	});

}(jQuery));  