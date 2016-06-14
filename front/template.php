<?php
/**
 * Template for the /styleguide route.
 * 
 */
?>

<head>
	<title>Styleguide</title>
<?php wp_head(); ?>
</head>

<body id="styleguide">
	<div id="app">
		<button @click="showSettings = true" id="settings" class="sg-button sg-button__settings">Settings</button>
		<settings 
		:show.sync="showSettings"
		:private="settings.private"
		:endpoint="settings.endpoint"
		></settings>
			<navbar :sections="all_sections"></navbar>
		<wrapper 
			v-for="section in all_sections"
			:id="section.id"
			:title="section.title"
			:styles="section.styles"
			:slug="section.slug"
			></wrapper>
			
			<form class="sg-section-title__edit" v-on:submit="addWrapper">
				<input type="text" class="sg-stack sg-font-dark sg-section-title sg-style-title" placeholder="New Section Title" />
				<button class="sg-button">Add</button>
			</form>
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

String.prototype.splice = function(i, remove, add) {
	remove = +remove || 0;
	add = add || '';
	
	return this.slice(0,i) + add + this.slice(i + remove);
};
 
 function offset(element) {
    var left = 0, top = 0, el = element;
    
    if (el.parentNode) {
		do {
			left += el.offsetLeft - el.scrollLeft;
			top += el.offsetTop - el.scrollTop;
		} while ((el = el.parentNode) && el.nodeType < 9);
	}

    return {
		top: top,
    	right: innerWidth - left - element.offsetWidth,
    	bottom: innerHeight - top - element.offsetHeight,
    	left: left,
    };
}

HTMLPreElement.prototype.setSelectionRange = function(ss, se) {
	var range = document.createRange(),
	    offset = findOffset(this, ss);

	range.setStart(offset.element, offset.offset);
	
	if(se && se != ss) {
		offset = findOffset(this, se);	
	}
	
	range.setEnd(offset.element, offset.offset);
		
	var selection = window.getSelection();
	selection.removeAllRanges();
	selection.addRange(range);
}

function findOffset(root, ss) {
	if(!root) {
		return null;
	}

	var offset = 0,
		element = root;
	
	do {
		var container = element;
		element = element.firstChild;
		
		if(element) {
			do {
				var len = element.textContent.length;
				
				if(offset <= ss && offset + len > ss) {
					break;
				}
				
				offset += len;
			} while(element = element.nextSibling);
		}
		
		if(!element) {
			// It's the container's lastChild
			break;
		}
	} while(element && element.hasChildNodes() && element.nodeType != 3);
	
	if(element) {
		return {
			element: element,
			offset: ss - offset
		};
	}
	else if(container) {
		element = container;
		
		while(element && element.lastChild) {
			element = element.lastChild;
		}
		
		if(element.nodeType === 3) {
			return {
				element: element,
				offset: element.textContent.length
			};
		}
		else {
			return {
				element: element,
				offset: 0
			};
		}
	}
	
	return {
		element: root,
		offset: 0,
		error: true
	};
}

Function.prototype.debounce = function (milliseconds, context) {
    var baseFunction = this,
        timer = null,
        wait = milliseconds;

    return function () {
        var self = context || this,
            args = arguments;

        function complete() {
            baseFunction.apply(self, args);
            timer = null;
        }

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(complete, wait);
    };
};

Function.prototype.throttle = function (milliseconds, context) {
    var baseFunction = this,
        lastEventTimestamp = null,
        limit = milliseconds;

    return function () {
        var self = context || this,
            args = arguments,
            now = Date.now();

        if (!lastEventTimestamp || now - lastEventTimestamp >= limit) {
            lastEventTimestamp = now;
            baseFunction.apply(self, args);
        }
    };
};
})();
</script>
<?php wp_footer(); ?>
</body>
