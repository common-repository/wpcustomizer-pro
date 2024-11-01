/**
 * vsElementCustomizer object
 * contains all properties, methods and options of Visual Styler Element Customizer
 */


(function () {

	$(function () {
		/*
		 * Define global object - vsElementCustomizer
		 */
		vsElementCustomizer = {

			/* PROPERTIES */

			/*
			 * WATCHER for current state of Element Customizer
			 *  True or False
			 * !IMPORTANT! : To change this attribute use function 'changeState'
			 */
			isActive: false,

			/* Selector of Element Customizer */
			selectorElementCustomizer: $('#vstyler-live-bar #vstyler-window-customizer'),

			selectorElementPath :$('#vstyler-live-bar #vstyler-window-customizer .customizer-element-path-wrapper .element-path-content'),

			/* HTML selector of the Customizer Options Panel */
			selectorOptionsPanel: $('#vstyler-live-bar #vstyler-window-customizer .customizer-element-styling-wrapper .options-panel .customizer-options-nav>.nav-item'),

			/* HTML selector of the Customizer CSS Options Tabs */
			selectorCSSOptionsTabs : $('#vstyler-live-bar #vstyler-window-customizer .element-styling-content .customizer-css-options-tabs>.nav-item'),
			/* HTML selector of the Customizer CSS Options Tabs Content */
			selectorCSSOptions : $('#vstyler-live-bar #vstyler-window-customizer .element-styling-content .customizer-css-options>.tabs-content-inner'),

			/* Selected element for customization */
			currentElement: '',

			/* Parents with classes and IDs of the currentElement */
			elementParentsTree:[],

			/* RegExp for IDs which should be enabled by default */
			enabledIDsRegExp: '',

			/* RegExp for Classes which should be enabled by default */
			enabledClassesRegExp: '',

			/*
			 * Actual element selector which will be used in final generated CSS code
			 * When customizer is initialized - this variable is generated in buildElementPathForm method
			 * Then this variable is changed by getFinalElementSelector method which is attached to element path checkbox change event
			 */
			elementSelector: '',

			/* Actual element state (normal or hover) which will be used in final generated CSS code */
			elementSelectorState: '',

			/* Actual element breakpoint which will be used in final generated CSS code*/
			elementSelectorBreakpoint: '',

			/* Final generated CSS code as string*/
			elementCSSCode:'',

			/* List of CSS properties (from _config.php -> $vStylerCSSOptions )*/
			CSSProperties: '',

			/* JSON object of the original CSS rules
			 * Init in fillInCSSOptionsForm()
			 */
			originalCSSValues:{},
			/* JSON object of  the new CSS rules */
			newCSSValues:{},



			/* METHODS */

			/*
			 * Change 'vsElementCustomizer'
			 *
			 * param (bool) state: state to switch (true or false)
			 * If not passed - state will be toggled (eg from true to false)
			 */
			changeState: function(state){
				// vsElementCustomizer object
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
			 * Initialize the Element Customizer
			 */
			init: function () {
				// vsElementCustomizer object
				var $this = this;

				$this.currentElement=vsElementChooser.currentElement;

				$this.enabledIDsRegExp=$this.getEnabledIDsRegExp();
				$this.enabledClassesRegExp=$this.getEnabledClassesRegExp();

				$this.getElementParentsTree();

				// display Customizer Window
				$this.displayCustomizer();

				// init the first CSS Options Tab
				$this.displayCSSOptionsTab($(vsElementCustomizer.selectorCSSOptionsTabs.get(0)));
			},

			/*
			 * Destroy the Element Customizer
			 */
			destroy: function () {
				// vsElementCustomizer object
				var $this = this;

				$this.currentElement='';

				$this.elementParentsTree=[];

				$this.elementSelector='';
				$this.elementCSSCode='';
				$this.elementSelectorState='';
				$this.elementSelectorBreakpoint='';

				vsElementCustomizer.originalCSSValues={};
				vsElementCustomizer.newCSSValues={};

				// hide Customizer Window
				$this.hideCustomizer();

				// reset Customizer CSS Options Tabs
				$this.hideCSSOptionsTab();
			},

			/*
			 * View final generated CSS code
			 */
			showFinalCSSCode: function(){
				// vsElementCustomizer object
				var $this = this;

				$('#customizer-css-options-wrapper').toggle();
				$('#customizer-css-code-wrapper').toggle();
			},

			/*
			 * Save final generated CSS code
			 */
			saveFinalCSSCode: function(){
				// vsElementCustomizer object
				var $this = this;


				var code = $("#customizer-css-code").val();
				$.ajax({
					data: {
						action: 'vstyler_ajax_request',
						action_type: 'update_css',
						nonce: vsHelper.wpAjax.nonce,
						css_code:code
					},
					type: 'post',
					dataType: 'json',
					url: vsHelper.wpAjax.ajaxURL,
					success: function(response) {
						vsHelper.updateInlineCSS();

					},
					error   : function( xhr, err ) {
						// Log errors if AJAX call is failed
						//	console.log(xhr);
						//	console.log(err);
					}
				});
			},

			/*
			 * Get element selector which will be used in generated CSS code
			 */
			getFinalElementSelector: function (){
				// vsElementCustomizer object
				var $this = this;
				var finalElementSelector='';
				$('ul',$this.selectorElementPath).each(function(i, item){
					$('input[type=checkbox]',item).each(function(itemID,itemCheckbox){
						if($(itemCheckbox).is(':checked')) {
							finalElementSelector += itemCheckbox.name;
						}
					});
					finalElementSelector+=' ';
				});
				// Remove last space from finalElementSelector
				$this.elementSelector=finalElementSelector.slice(0,-1);
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Display element customizer
			 */
			displayCustomizer: function () {
				// vsElementCustomizer object
				var $this = this;

				var pathForm=$this.buildElementPathForm();
				$('.customizer-element-path-wrapper .element-path-content',$this.selectorElementCustomizer).html(pathForm);
				$this.fillInCSSOptionsForm();
				$this.selectorElementCustomizer.slideDown()
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Hide element customizer
			 */
			hideCustomizer: function () {
				// vsElementCustomizer object
				var $this = this;

				$('.customizer-element-path-wrapper .element-path-content',$this.selectorElementCustomizer).html('');
				$this.selectorElementCustomizer.slideUp()
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Display CSS Options Tab content
			 */
			displayCSSOptionsTab: function (object) {
				// vsElementCustomizer object
				var $this = this;

				var currentTab=object.data('vstyler-content');
				object.addClass('active');
				$('#'+currentTab).show();
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Hide CSS Options Tab content
			 */
			hideCSSOptionsTab: function () {
				// vsElementCustomizer object
				var $this = this;

				$this.selectorCSSOptionsTabs.removeClass('active');
				$this.selectorCSSOptions.hide();
			},

			/*
			 *  PRIVATE FUNCTION
			 *
			 *  Generate RegExp for IDs which should be enabled by default
			 */
			getEnabledIDsRegExp: function () {
				return vsElementChooser.jsonToRegExp(vsElementChooser.enabledIDs);
			},

			/*
			 *  PRIVATE FUNCTION
			 *
			 *  Generate RegExp for Classes which should be enabled by default
			 */
			getEnabledClassesRegExp: function () {
				return vsElementChooser.jsonToRegExp(vsElementChooser.enabledClasses);
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Get element parents tree
			 */
			getElementParentsTree: function () {
				// vsElementCustomizer object
				var $this = this;

				var parents=$($this.currentElement).parents();
				// Start from body (ignore HTML element) - parents.length-2
				for (var i = parents.length-2; i >= 0; i--) {
					var newObject={
						name: parents[i].tagName.toLowerCase(),
						isDisabled: false,
						classes: '',
						IDs: ''
					};
					newObject.classes=($this.getElementDetails({element: parents[i],details: 'class'}));
					newObject.IDs=($this.getElementDetails({element: parents[i],details: 'id'}));
					$this.elementParentsTree.push(newObject);
				}
				var currentObject={
					name: $this.currentElement.tagName.toLowerCase(),
					isDisabled: true,
					classes: '',
					IDs: ''
				};
				currentObject.classes=($this.getElementDetails({element: $this.currentElement,details: 'class'}));
				currentObject.IDs=($this.getElementDetails({element: $this.currentElement,details: 'id'}));
				$this.elementParentsTree.push(currentObject);
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Return array of classes or IDs of the element
			 * Array contain json-object with the following structure:
			 *	{
			 *		name: 'className(or)idName',
			 *  	isChecked: false // if className or idName checkbox should be checked by default
			 *	}
			 *
			 * params (json object):
			 * 			object element - selected element
			 * 			string details - class or id
			 */
			getElementDetails: function (params) {
				// vsElementCustomizer object
				var $this = this;

				var element = typeof params.element !== 'undefined' ? params.element : $this.currentElement;
				var details = typeof  params.details !== 'undefined' ? params.details : 'class';

				var elemDetails = [];
				if (details == 'id') {
					// Get parent IDs
					if (element.id) {
						var elementIDs=element.id.trim().split(/\s+/);
						for (var i = 0; i < elementIDs.length; i++) {
							var idName=elementIDs[i];
							var isIDChecked=(idName.match($this.enabledIDsRegExp)!==null)?true:false;
							elemDetails.push({name:idName, isChecked: isIDChecked});
						}
					}
				}
				if (details == 'class') {
					// Get parent classes
					if (element.className) {
						var elementClasses=element.className.trim().split(/\s+/);
						for (var i = 0; i < elementClasses.length; i++) {
							var className=elementClasses[i];
							var isClassChecked=(className.match($this.enabledClassesRegExp)!==null)?true:false;
							elemDetails.push({name:className, isChecked: isClassChecked});
						}
					}
				}
				return elemDetails;
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Build Element parent tree with classes, IDs and checkboxes
			 */
			buildElementPathForm: function(){
				// vsElementCustomizer object
				var $this = this;
				var pathForm='';
				var finalElementSelector='';
				$.each($this.elementParentsTree, function(i, item) {
					pathForm+='<ul class="element-details-list">';
					pathForm+='<li class="elementTag"><label><input type="checkbox" name="'+(item.name)+'" checked '+(item.isDisabled?'disabled':'')+'>'+(item.name)+'</label></li>';
					finalElementSelector += item.name;
					$.each(item.IDs, function(iID, itemID) {
						pathForm+='<li class="elementID"><label><input type="checkbox" name="#'+(itemID.name)+'" '+(itemID.isChecked?'checked':'')+'>#'+(itemID.name)+'</label></li>';
						if(itemID.isChecked){finalElementSelector += '#' + itemID.name;}
					});
					$.each(item.classes, function(iClass, itemClass) {
						pathForm+='<li class="elementClass"><label><input type="checkbox" name=".'+(itemClass.name)+'" '+(itemClass.isChecked?'checked':'')+'>.'+(itemClass.name)+'</label></li>';
						if(itemClass.isChecked){finalElementSelector += '.' + itemClass.name;}
					});
					finalElementSelector+=' ';
					pathForm+='</ul>';
				});

				// Remove last space from finalElementSelector
				$this.elementSelector=finalElementSelector.slice(0,-1);
				return pathForm;
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Fill in CSS Options form
			 */
			fillInCSSOptionsForm: function(){
				// vsElementCustomizer object
				var $this = this;

				var iFrameElement = $('#vstyler-live #vstyler-live-iframe');

				$.each($this.CSSProperties, function(iTab, tabObject) {

					$.each(tabObject, function(iProperty,CSSProperty){
						var CSSPropertyName=CSSProperty.name;
						var CSSValue=$($this.elementSelector,iFrameElement.contents()).css(CSSPropertyName);
						var CSSField=$('#'+CSSPropertyName);
						// Apply current CSS value to form field
						CSSField.val(CSSValue);
						// Save inital CSS value to originalCSSValues object
						$this.originalCSSValues[CSSPropertyName] = CSSValue;
						if(CSSProperty.field.type=='colorpicker'){
							CSSField.css( 'border-color', CSSValue);
						}
					});
				});
			},

			updateElementCSSCode: function(){
				if($.isEmptyObject(vsElementCustomizer.newCSSValues)!==true){
					var newCSS='';
					$.each(vsElementCustomizer.newCSSValues,function(name,val){
						newCSS+= name + ':' + val+';';
					});
					vsElementCustomizer.elementCSSCode=newCSS;
				}
			},

			/*
			 * Input field property watch (used instead of 'change' event listener)
			 */
			watchProperty: function (obj, name, handler) {
				/* Doesnt work in FireFox
				 if ('watch' in obj) {
				 obj.watch(name, handler);
				 } else if ('onpropertychange' in obj) {
				 name= name.toLowerCase();
				 obj.onpropertychange= function() {
				 if (window.event.propertyName.toLowerCase()===name)
				 handler.call(obj);
				 };
				 } else { */
				var o= obj[name];
				setInterval(function() {
					var n= obj[name];
					if (o!==n) {
						o= n;
						handler.call(obj);
					}
				}, 200);
				/* } */
			}






		}

	});

}(jQuery));  