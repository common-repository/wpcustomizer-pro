/**
 * vsElementChooser object
 * contains all properties, methods and options of elementChooser feature
 */


(function () {

	$(function () {
		/*
		 * Define global object - vsElementChooser
		 */
		vsElementChooser = {


			/* PROPERTIES */

			/* HTML selector of element chooser */
			selector: $('#vstyler-live-bar .vstyler-live-bar-nav .select-element'),

			/* Selector for element path label */
			selectorHTMLPathLabel: $('#vstyler-live-bar  #vstyler-element-path-label'),
			/* Element Path Value */
			elementPathValue: '',

			/*
			 * WATCHER for Hotkeys
			 * Current pressed keyCode keyCode
			 */
			currentHotkey: '',

			/*
			 * WATCHER for current element
			 * object
			 */
			currentElement: '',
			/*
			 * WATCHER for current element action (string)
			 * eg mouseover, mouseout, click, etc
			 */
			currentElementAction: '',
			/*
			 * WATCHER to check if current element is selected for customization
			 * True or False
			 */
			isCurrentElementSelected: false,

			/* List of default WordPress IDs which are enabled by default */
			enabledIDs:'',

			/* List of default WordPress classes which are enabled by default */
			enabledClasses:'',

			/*
			 * WATCHER for state of element chooser
			 *  True or False
			 * !IMPORTANT! : To change this attribute use function 'changeState'
			 */
			isActive: false,

			options: {
				styles: {
					targetMouseOver: {'outline': '1px dashed #2980B9'},
					targetMouseOut: {'outline': 'none'}
				}
			},

			/* METHODS */

			/*
			 * Change 'isActive'
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
				return true;
			},


			/*
			 * Get main element details
			 * params (json object):
			 * 			object element - selected element
			 * 			string details - full (returns tagName+IDs+classes), short (returns only tagName)
			 */
			getMainElement: function (params) {
				// vsElementChooser object
				var $this = this;

				var element = typeof params.element !== 'undefined' ? params.element : $this.currentElement;
				var details = typeof  params.details !== 'undefined' ? params.details : 'full';

				// Get element tag name
				var elemDetails = element.tagName.toLowerCase();

				elemDetails += $this.getElementDetails({
					element: element,
					details: details
				});

				return elemDetails;
			},

			/*
			 * Get element path
			 * params (json object):
			 * 			object element - selected element
			 * 			int deep - count of returned parents, default -1 (all parents will be returned)
			 * 			string details - full (returns tagName+IDs+classes), short (returns only tagName)
			 * 			string separator - separator between parents, whitespace is default
			 * 			bool ignoreElement - if true - only parents path will be returned (without main element details)
			 *
			 * Return: element full path if deep is not set, and short path if deep is set
			 *
			 * Solutions:
			 * http://stackoverflow.com/questions/5728558/get-the-dom-path-of-the-clicked-a
			 * http://stackoverflow.com/questions/12644147/getting-element-path-for-selector
			 */
			getElementPath: function (params) {
				// vsElementChooser object
				var $this = this;

				var element = typeof params.element !== 'undefined' ? params.element : $this.currentElement;
				var deep = typeof params.deep !== 'undefined' ? params.deep : -1;
				var details = typeof  params.details !== 'undefined' ? params.details : 'full';
				var separator = typeof  params.separator !== 'undefined' ? params.separator : ' ';
				var ignoreElement = typeof  params.ignoreElement !== 'undefined' ? params.ignoreElement : false;

				var elemParents = [];

				// Get main element details
				if (ignoreElement !== true) {
					elemParents.push(this.getMainElement(params));
				}
				// Get parents
				$(element).parents().not('html').each(function () {

					// If deep is set - return the count specified in deep
					var parentsCount = elemParents.length;
					if (parentsCount == deep) {
						return false;
					}

					// Get parent tag name
					var entry = this.tagName.toLowerCase();

					entry += $this.getElementDetails({
						element: this,
						details: details
					});

					elemParents.push(entry);
				});
				elemParents.reverse();

				return (elemParents.join(separator));
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Convert JSON object to REGEXP
			 * Mainly used in 'getElementDetails' function to find matches in classes and IDs which should be enabled/displayed by default
			 *
			 * Return regexp eg: /^(class-1|class-2|class-3)$/
			 */
			jsonToRegExp : function(json){
				var json = typeof json !== 'undefined' ? json : null;
				if(json == null){return false;}

				var str='^(';
				$.each(json, function(i, item) {
					str+=(item.join('|'))+'|';
				});
				// remove last "|" symbol to remove empty alternative from our RegExp
				str=str.slice(0,-1);

				str+=')$';

				var regexp = new RegExp(str);
				return regexp;
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Return details such as IDs and class names of the element
			 *
			 * params (json object):
			 * 			object element - selected element
			 * 			string details - full (returns tagName+IDs+classes), short (returns only tagName)
			 */
			getElementDetails: function (params) {
				// vsElementChooser object
				var $this = this;

				var element = typeof params.element !== 'undefined' ? params.element : $this.currentElement;
				var details = typeof  params.details !== 'undefined' ? params.details : 'full';

				var elemDetails = '';
				if (details == 'full') {

						// Get parent IDs
						if (element.id) {
							var elementIDs=element.id.trim().split(/\s+/);
							var idRegExp=$this.jsonToRegExp($this.enabledIDs);
							for (var i = 0; i < elementIDs.length; i++) {
								var idName=elementIDs[i];
								var isIDChecked=(idName.match(idRegExp)!==null)?true:false;
								if(isIDChecked===true) {
									elemDetails += '#'+idName;
								}
							}
						}
						// Get parent classes
						if (element.className) {
							var elementClasses=element.className.trim().split(/\s+/);
							var classesRegExp=$this.jsonToRegExp($this.enabledClasses);
							for (var i = 0; i < elementClasses.length; i++) {
								var className=elementClasses[i];
								var isClassChecked=(className.match(classesRegExp)!==null)?true:false;
								if(isClassChecked===true) {
									elemDetails += '.'+className;
								}
							}
						}
				}
				return elemDetails;
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Display element path when choosing element
			 */
			displayElementPathLabel: function () {
				// vsElementChooser object
				var $this = this;

				$this.selectorHTMLPathLabel.html($this.elementPathValue);
				$this.selectorHTMLPathLabel.show();
			},

			/*
			 * PRIVATE FUNCTION
			 *
			 * Hide element path
			 */
			hideElementPathLabel: function () {
				// vsElementChooser object
				var $this = this;
				$this.selectorHTMLPathLabel.html('');
				$this.selectorHTMLPathLabel.hide();
			}

		}

	});

}(jQuery));  