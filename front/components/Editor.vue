<template>
	<pre 
		tabindex="2" 
		:contenteditable="editing" 
		class="language-markup"
		v-on:keyup="handleKeyup"
		v-on:keydown="handleKeydown"
		v-on:focus="handleFocus"
		v-on:paste="handlePaste"
		>{{ html | comments }}</pre>
</template>
<script>
import Prism from 'prismjs';
import actions from '../common/actions.js';
export default {
	props: ['html', 'editing'],
	
	ready: function() {
		var pre = this.$el;
		Prism.highlightElement(pre);
	},
	
	vuex: {
		getters: {
			undoStack: function(state) {
				return state.undoStack;
			},
			
			redoStack: function(state) {
				return state.redoStack
			}
		},
		actions: {
			updateHtml: actions.updateHtml,
			undo: actions.undoHtml,
			redo: actions.redoHtml
		}
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
	},
	
	watch: {
		editing: function(val) {
			if( val ) {
				console.log(this.$el);
			}
		}
	},
	
	methods: {
		
		debounceUpdate: function( code, style, ss, se ) {
			this.updateHtml(code, style, ss, se);
		}.debounce(250),
		
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
		
		handleUndo: function() {
			var l = this.undoStack.length - 1;
			var latest = this.undoStack[l];
			this.$el.textContent = latest.html;
			Prism.highlightElement( this.$el );
			this.$el.setSelectionRange(latest.ss, latest.se);
			this.undo( this.$parent.style );
		},
		
		handleRedo: function() {
			var l = this.redoStack.length - 1;
			var latest = this.redoStack[l];
			this.$el.textContent = latest.html;
			Prism.highlightElement( this.$el );
			this.$el.setSelectionRange(latest.ss, latest.se);
			this.undo( this.$parent.style );
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
				Prism.highlightElement(this.$el);
				this.debounceUpdate( code, this.$parent.style, ss, se );
				
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
				case 89:
					if(cmdOrCtrl) {
						console.log('here');
						this.handleRedo();
						evt.preventDefault();
						return false;
					}
				case 90:
					if(cmdOrCtrl) {
						this.handleUndo();
						return false;
					}
					break;
			}
		},
	
		action: function(action, options) {
			var pre = this.$el,
			text = pre.textContent,
			ss = pre.selectionStart,
			se = pre.selectionEnd;
			this.state.ss = ss;
			this.state.se = se;
			this.state.before = text.slice(0, ss);
			this.state.after = text.slice(se);
			this.state.selection = text.slice(ss, se);
			
			var textAction = this[action](options);
			
			//console.log('before: ' + this.state.before + '\n selection: ' + this.state.selection + ' after: ' + this.state.after );
			pre.textContent = this.state.before + this.state.selection + this.state.after;
			pre.setSelectionRange(this.state.ss, this.state.se);
			
			Prism.highlightElement(pre);
			if(!/\n$/.test(this.state.after)) {
				pre.innerHTML = pre.innerHTML + '\n';
			}
			pre.setSelectionRange(this.state.ss, this.state.se);
			
		},
		
			newline: function() {
				var ss = this.state.ss,
						lf = this.state.before.lastIndexOf('\n') + 1,
						indent = (this.state.before.slice(lf).match(/^\s+/) || [''])[0];
				
				this.state.before += '\n' + indent;
				
				var selection = this.state.selection;
				this.state.selection = '';	
				
				this.state.ss += indent.length + 1;
				this.state.se = this.state.ss;
			},
			
			indent: function(options) {
				var lf = this.state.before.lastIndexOf('\n') + 1;
			
				if (options.inverse) {
					if(/\s/.test(this.state.before.charAt(lf))) {
						this.state.before = this.state.before.splice(lf, 1);
						
						this.state.ss--;
						this.state.se--;
					}
					
					this.state.selection = this.state.selection.replace(/\r?\n\s/g, '\n');
				}
				else if (this.state.selection) {
					this.state.before = this.state.before.splice(lf, 0, '\t');
					this.state.selection = this.state.selection.replace(/\r?\n/g, '\n\t');
					
					this.state.ss++;
					this.state.se++;
				}
				else {
					this.state.before += '\t';
					
					this.state.ss++;
					this.state.se++;
				}
			},
			
			comment: function(options) {
				var open = '<!--',
						close = '-->';
				var start = this.state.before.lastIndexOf(open),
						end = this.state.after.indexOf(close),
						closeBefore = this.state.before.lastIndexOf(close),
						openAfter = this.state.after.indexOf(start);
		
				if(start > -1 && end > -1 && (start > closeBefore || closeBefore === -1) 
				&& (end < openAfter || openAfter === -1) ) {
						// Uncomment
						this.state.before = this.state.before.splice(start, open.length);
						this.state.after = this.state.after.splice(end, close.length);
		
						this.state.ss -= open.length;
						this.state.se -= open.length;
		
					} else {
						// Comment
						if(this.state.selection) {
							// Comment selection
							this.state.selection = open + this.state.selection + close;
						} else {
							// Comment whole line
							start = this.state.before.lastIndexOf('\n') + 1;
							end = this.state.after.indexOf('\n');
				
							if(end === -1) {
								end = after.length;
							}
				
							while(/\s/.test(this.state.before.charAt(start))) {
								start++;
							}
				
							this.state.before = this.state.before.splice(start, 0, open);
				
							this.state.after = this.state.after.splice(end, 0, close);
				
						}
			
						this.state.ss += open.length;
						this.state.se += open.length;
				}
			}
	}
}
</script>