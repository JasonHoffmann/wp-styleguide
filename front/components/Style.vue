<style lang="scss">
#styleguide {
	.sg-st {
		background: white;
		padding: 16px;
		box-shadow: 0 0 1px rgba(0,0,0,.15);
		margin: 2em 0;
		position: relative;
		overflow: hidden;
	}
	
	.sg-st__actions {
		text-align: right;
		
		.sg-button:first-child:hover {
			background: $green;
			color: $white !important;
		}
	}
	

	
	.sg-st__toggle {
		position: absolute;
		top: 24px;
		right: 10px;
		opacity: 0;
		transition: opacity 0.2s;
	}
	
	.sg-st:hover .sg-st__toggle {
		opacity: 1;
	}
	
	.sg-st__trash:hover svg {
		fill: $red;
	}
	
	.sg-st__title {
		margin: 0 0 0 0;
		padding: 5px;
		border-bottom: 1px dotted $gray-lighter;
		width: 100%;
		font-weight: bold;
		font-size: 21px;
		border-radius: 0;
	}
	
	input.sg-st__title {
		border: none;
		padding: 10px 5px;
		
	}
	
	.sg-st__markupbutton {
		border: none;
		box-shadow: none;
		svg {
			margin: 0 0 3px 0;
		}
		
		&:hover {
			box-shadow: none;
			svg {
				fill: $gray-dark;
			}
		}
	}
	
	.sg-st__markupbutton.m-active {
		box-shadow: inset 0 -10rem 0 rgba(158,158,158,.1);
	}

	.sg-st__markuptext {
		color: $gray-light;
		font-style: italic;
		font-weight: 100;
		font-size: 12px;
		margin-left: 10px;
	}
	
	.sg-st__output {
		margin: 24px 0;
	}
	
	.sg-st__confirm {
		position: absolute;
		background: rgba(239,83,80 ,1);;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		color: #fff;
		text-align: center;
		font-weight: 700;
		display: flex;
		justify-content: center;
		flex-direction: column;
		flex-wrap: wrap;
		align-items: center;
		font-size: 24px;
		z-index: 10;
		
		button {
      color: white !important;
      border: 1px solid white;
      padding: 5px 20px;
      &:hover {
        background: white;
        color: rgba(239,83,80 ,1) !important;
        
      }
    }
	}
	
	.expand-transition {
  transition: all 0.3s cubic-bezier(0.215, 0.61, 0.355, 1);
	transform: translateY(0);
  overflow: hidden;
}

.expand-enter, .expand-leave {
	transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
	transform: translateY(100%);
}
}
</style>

<template>
<section id="{{ style.slug }}" class="sg-st">
		
		<div v-if="confirm" transition="expand" class="sg-st__confirm sg-stack">
			<p>Are you sure you want to delete this style?</p>
			<div>
				<button class="sg-button sg-confirm-button" v-on:click="deleteStyle">Yes</button>
				<button class="sg-button sg-confirm-button" v-on:click="toggleConfirm">No</button>
			</div>
		</div>
		
		<form class="sg-stack" v-if="editing" v-on:submit.prevent="editStyle">
			<input 
						placeholder="Add a title..." 
						type="text" class="sg-st__title sg-st__input" 
						v-model="style.title" 
						v-if="editing"
						tabindex="1"
						lazy
				/>
		</form>
		
		<div v-else>
			<h4 class="sg-stack sg-st__title">{{ style.title }}</h4>
			<span class="sg-st__toggle">
				<button v-on:click="enterEditing" class="sg-button">
					<icon name="edit"></icon>
				</button>
				<button v-on:click="toggleConfirm" class="sg-button sg-st__trash">
					<icon name="delete"></icon>
				</button>
			</span>
		</div>
		
		<output :html="style.html"></output>
		
		
		<div class="sg-markuptoggle">
			<button class="sg-button sg-st__markupbutton" v-bind:class="{ 'm-active' : showMarkup || editing }" v-on:click="toggleMarkup">
				<icon name="markup"></icon>
			</button>
			<span class="sg-stack sg-st__markuptext" v-show="editing">Edit Markup Below</span>
		</div>
		
    <div class="sg-markup" v-show="editing || showMarkup">
      <code-editor :html.sync="style.html" :editing="editing"></code-editor>
    </div>
		
		<div v-if="editing" class="sg-st__actions">
			<button v-on:click.prevent="editStyle" class="sg-button">
				{{ save_text }}
			</button>
			
			<button class="sg-button" v-on:click="exitEditing">
				Cancel
			</button>
		</div>
		
		
</section>
</template>

<script>
import CodeEditor from './Editor.vue';
import Output from './Html.vue';
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  props: ['style', 'index', 'section'],
  
  vuex: {
		getters: {
			logged_in: function(store) {
				return store.logged_in
			}
		},
    actions: {
      updateStyle: actions.updateStyle,
      removeStyle: actions.removeStyle,
			saveNewStyle: actions.saveNewStyle
    }
  },
  
  data: function() {
    return {
      showMarkup: false,
      editing: false,
      confirm: false,
      prev: {}
    }
  },
	
	computed: {
		save_text: function() {
			if(this.style.id > 0 ) {
				return 'Save';
			} else {
				return 'Save New';
			}
		}
	},
  
  created: function() {
    if( !this.style.title && this.logged_in ) {
      this.editing = true;
    }
  },
  
  ready: function() {
		this.focusInput();
  },
  
  components: {
    CodeEditor,
		Icon,
		Output
  },
	
  methods: {
		
		focusInput: function() {
			var input = this.$el.querySelectorAll('.sg-st__input');
			if( input.length > 0 ) {
				input[0].focus();
			}
		},
		
		toggleMarkup: function() {
			this.showMarkup = !this.showMarkup
		},
    
    enterEditing: function(evt) {
      this.editing = true;
      this.prev = {
        title: this.style.title,
        html: this.style.html
      }
    },
    
    exitEditing: function(evt) {
      this.editing = false;
      this.style.title = this.prev.title;
      this.style.html = this.prev.html
    },
    
    editStyle: function() {
			if( this.style.id > 0 ) {
				this.updateStyle({
					title: this.style.title,
					html: this.style.html,
					id: this.style.id
				}, this.style);
			} else {
				this.saveNewStyle(this.style, this.$parent.section);
			}
			
      this.editing = false;
    },
		
		deleteStyle: function() {
			this.confirm = false;
      this.removeStyle( this.index, this.section, this.style.id )
		},
		
		toggleConfirm: function() {
			this.confirm = !this.confirm;
		}
  },
	
	watch: {
		editing: function(val) {
			if(val === true) {
				this.focusInput();
			}
		}
	}
}
</script>