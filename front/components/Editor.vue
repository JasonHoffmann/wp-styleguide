<template>
	<pre 
		tabindex="2" 
		:contenteditable="editing" 
		class="language-markup"
		v-on:keyup="handleKeyup"
		v-on:keydown="handleKeydown"
		v-on:focus="handleFocus"
		v-on:paste="handlePaste"
		>
		{{ html }}</pre>
</template>
<script>
import Prism from 'prismjs'
export default {
	props: ['html', 'editing'],
	
	ready: function() {
		var pre = this.$el;
		Prism.highlightElement(pre);
	},
	
	data: function() {
		return {
			state: {
				ss: '',
				se: '',
				before: '',
				after: '',
				selection: ''
			}
		}
	}
	
	methods: {
		
		handlePaste: function(evt) {
			var self = this;
			setTimeout(function() {
				self.handleKeyup(evt);
			}, 10);
		},
		
		handleFocus: function(evt) {
			if( !this.editing ) {
				var cell = this.$el;
				var range, selection;
				if (document.body.createTextRange) {
					range = document.body.createTextRange();
					range.moveToElementText(cell);
					range.select();
				} else if (window.getSelection) {
					selection = window.getSelection();
					range = document.createRange();
					range.selectNodeContents(cell);
					selection.removeAllRanges();
					selection.addRange(range);
				}
			}
		},
		
		handleKeyup: function(evt) {
			var keyCode = evt.keyCode;
			var code = this.$el.textContent;
			
			if([
					9, 91, 93, 16, 17, 18, // modifiers
					20, // caps lock
					13, // Enter (handled by keydown)
					112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, // F[0-12]
					27 // Esc
			].indexOf(keyCode) > -1) {
					return;
			}
			

			
			if (keyCode !== 37 && keyCode !== 39) {
					var ss = this.$el.selectionStart;
					var se = this.$el.selectionEnd;
				console.log(code);
				Prism.highlightElement(this.$el);
				this.html = code;
				
				if(!/\n$/.test(code)) {
					this.$el.innerHTML = this.$el.innerHTML + '\n';
				}
					
				if(ss !== null || se !== null) {
					this.$el.setSelectionRange(ss, se);
				}
			}
		},
		
		handleKeydown: function(evt) {
			var cmdOrCtrl = evt.metaKey || evt.ctrlKey;
			switch(evt.keyCode) {
				case 9: // Tab
					if(!cmdOrCtrl) {
						this.action('indent', {
							inverse: evt.shiftKey
						});
						evt.preventDefault();
						return false;
					}
					break;
				case 13:
					this.action('newline');
					evt.preventDefault();
					return false;
				case 191:
					if(cmdOrCtrl && !evt.altKey ) {
						this.action('comment');
						evt.preventDefault();
						return false;
					}
					break;
			}
		},
	
		action: function(action, options) {
			options = options || {};
			var pre = this.$el,
			text = pre.textContent,
			ss = options.start || pre.selectionStart,
			se = options.end || pre.selectionEnd;
			var state = {
					ss: ss,
					se: se,
					before: text.slice(0, ss),
					after: text.slice(se),
					selection: text.slice(ss,se)
				};
			var textAction = this[action](state, options);
			pre.textContent = state.before + state.selection + state.after;
			pre.setSelectionRange(state.ss, state.se);
			
			Prism.highlightElement(pre);
			if(!/\n$/.test(state.after)) {
				pre.innerHTML = pre.innerHTML + '\n';
			}
			pre.setSelectionRange(state.ss, state.se);
			
		},
		
			newline: function(state) {
				var ss = state.ss,
						lf = state.before.lastIndexOf('\n') + 1,
						indent = (state.before.slice(lf).match(/^\s+/) || [''])[0];
				
				state.before += '\n' + indent;
				
				var selection = state.selection;
				state.selection = '';	
				
				state.ss += indent.length + 1;
				state.se = state.ss;
			},
			
			indent: function(state, options) {
				var lf = state.before.lastIndexOf('\n') + 1;
			
				if (options.inverse) {
					if(/\s/.test(state.before.charAt(lf))) {
						state.before = state.before.splice(lf, 1);
						
						state.ss--;
						state.se--;
					}
					
					state.selection = state.selection.replace(/\r?\n\s/g, '\n');
				}
				else if (state.selection) {
					state.before = state.before.splice(lf, 0, '\t');
					state.selection = state.selection.replace(/\r?\n/g, '\n\t');
					
					state.ss++;
					state.se++;
				}
				else {
					state.before += '\t';
					
					state.ss++;
					state.se++;
				}
			},
			
			comment: function(state, options) {
				var open = '<!--',
						close = '-->';
				var start = state.before.lastIndexOf(open),
						end = state.after.indexOf(close),
						closeBefore = state.before.lastIndexOf(close),
						openAfter = state.after.indexOf(start);
		
				if(start > -1 && end > -1 && (start > closeBefore || closeBefore === -1) 
				&& (end < openAfter || openAfter === -1) ) {
						// Uncomment
						state.before = state.before.splice(start, open.length);
						state.after = state.after.splice(end, close.length);
		
						state.ss -= open.length;
						state.se -= open.length;
		
					} else {
						// Comment
						if(state.selection) {
							// Comment selection
							state.selection = open + state.selection + close;
						} else {
							// Comment whole line
							start = state.before.lastIndexOf('\n') + 1;
							end = state.after.indexOf('\n');
				
							if(end === -1) {
								end = after.length;
							}
				
							while(/\s/.test(state.before.charAt(start))) {
								start++;
							}
				
							state.before = state.before.splice(start, 0, open);
				
							state.after = state.after.splice(end, 0, close);
				
						}
			
						state.ss += open.length;
						state.se += open.length;
				}
			}
	}
}
</script>