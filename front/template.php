<?php
/**
 * Template for the /styleguide route.
 * 
 */
?>


<?php wp_head(); ?>

<body id="styleguide">
	<div id="app">
		<wrapper 
			v-for="section in all_sections"
			:id="section.id"
			:title="section.title"
			:styles="section.styles"></wrapper>
	</div>
<script>
// Adding some utilities globally for now
(function(){
	Object.defineProperty(HTMLPreElement.prototype, 'selectionStart', {
	get: function() {
		var selection = getSelection();
		
		if(selection.rangeCount) {
			var range = selection.getRangeAt(0),
				element = range.startContainer,
				container = element,
				offset = range.startOffset;
			
			if(!(this.compareDocumentPosition(element) & 0x10)) {
				return 0;
			}
			
			do {
				while(element = element.previousSibling) {
					if(element.textContent) {
						offset += element.textContent.length;
					}
				}
				
				element = container = container.parentNode;
			} while(element && element != this);
			
			return offset;
		}
		else {
			return 0;
		}
	},
	
	enumerable: true,
	configurable: true
});

Object.defineProperty(HTMLPreElement.prototype, 'selectionEnd', {
	get: function() {
		var selection = getSelection();
		
		if(selection.rangeCount) {
			return this.selectionStart + (selection.getRangeAt(0) + '').length;
		}
		else {
			return 0;
		}
	},
	
	enumerable: true,
	configurable: true
});
var _ = window.Utopia = {
	
	type: function(obj) {
	if(obj === null) { return 'null'; }

	if(obj === undefined) { return 'undefined'; }

	var ret = Object.prototype.toString.call(obj).match(/^\[object\s+(.*?)\]$/)[1];

	ret = ret? ret.toLowerCase() : '';

	if(ret == 'number' && isNaN(obj)) {
		return 'NaN';
	}

	return ret;
},
	
	event: {
	/**
	 * Binds one or more events to one or more elements
	 */
	bind: function(target, event, callback, traditional) {
		if(_.type(target) === 'string' || _.type(target) === 'array') {
			var elements = _.type(target) === 'string'? $$(target) : target;
			
			elements.forEach(function(element) {
				_.event.bind(element, event, callback, traditional);
			});
		}
		else if(_.type(event) === 'string') {
			if(traditional) {
				target['on' + event] = callback;
			}
			else {
				target.addEventListener(event, callback, false);
			}
		}
		else if(_.type(event) === 'array') {
			for (var i=0; i<event.length; i++) {
				_.event.bind(target, event[i], callback, arguments[2]);
			}
		}
		else {
			for (var name in event) {
				_.event.bind(target, name, event[name], arguments[2]);
			}
		}
	},
	
	/**
	 * Fire a custom event
	 */
	fire: function(target, type, properties) {
		if(_.type(target) === 'string' || _.type(target) === 'array') {
			var elements = _.type(target) === 'string'? $$(target) : target;
			
			elements.forEach(function(element) {
				_.event.fire(element, type, properties);
			});
		}
		else {
			var evt = document.createEvent("HTMLEvents");
	
			evt.initEvent(type, true, true );
			evt.custom = true;
	
			if(properties) {
				_.attach(evt, properties);
			}

			target.dispatchEvent(evt);
		}
	}
}
}
})();
window.$u = window.$u || Utopia;
</script>
<?php wp_footer(); ?>
</body>
