<template>
  <div id="{{ style.slug }}" class="sg-container">
		<div v-if="confirm" transition="expand" class="sg-confirm-style sg-stack">
			<p>Are you sure you want to delete this style?</p>
			<div class="sg-confirm-actions">
				<button class="sg-button sg-confirm-button" v-on:click="deleteStyle">Yes</button>
				<button class="sg-button sg-confirm-button" v-on:click="toggleConfirm">No</button>
			</div>
		</div>
		<h4 class="sg-style-title sg-stack" v-show="!editing">
			{{ style.title }}
		</h4>
			<span v-show="!editing && logged_in" class="sg-actions">
			<button v-on:click="enterEditing" class="sg-button__action">
				<icon name="edit"></icon>
			</button>
			<button v-on:click="toggleConfirm" class="sg-button__action">
					<icon name="delete"></icon>
		</button>
		</span>
		<input 
					placeholder="Add a title..." 
					type="text" class="sg-style-title sg-stack sg-font-light" 
					v-model="style.title" 
					v-bind:class="{'editing' : editing }"
					v-show="editing"
					autofocus
			/>
      <span v-show="editing" class="sg-actions sg-actions--editing">
      <button class="sg-button__action sg-button__save" v-on:click="editStyle">
        <icon name="save"></icon>
      </button>
      <button class="sg-button__action sg-button__cancel" v-on:click="exitEditing">
        <icon name="cancel"></icon>	
    </button>
  </span>
    <div class="sg-output">
        {{{ style.html }}}
    </div>
		<div class="sg-markuptoggle">
			<button class="sg-button__action" v-on:click="toggleMarkup" v-show="!editing">
				<icon name="markup"></icon>
			</button>
			<span v-show="editing" class="sg-markuptext">Edit the HTML below</span>
		</div>
    <div class="sg-markup" v-show="editing || showMarkup">
      <code-editor :html.sync="style.html" :editing="editing"></code-editor>
    </div>
  </div>
</template>

<style lang="scss">
#styleguide {
	.sg-container {
		background: white;
		padding: 24px;
		box-shadow: -1px 0 2px 0 rgba(0,0,0,0.12) , 1px 0 2px 0 rgba(0,0,0,0.12) , 0 1px 1px 0 rgba(0,0,0,0.24);
		border-radius: 1px;
		margin: 2em 0;
		position: relative;
	}
	
	
	.sg-actions {
		position: absolute;
		top: 24px;
		right: 10px;
		opacity: 0;
		z-index: 1;
	}
  
  .sg-actions--editing {
    opacity: 1;
    top: 30px;
    .sg-button__action svg {
      width: 19px;
      height: 19px;
    }
  }
  
  .sg-style-title {
    margin: 0 0 0 0;
    padding: 0 0 10px 0;
    border-bottom: 1px dotted #ddd;
    width: 100%;
    font-weight: bold;
    font-size: 24px;
    border-radius: 0;
  }
  
  input.sg-style-title {
    border: 1px solid #ddd;
    padding: 5px;
    width: 90%;
  }
	
	.sg-button__action {
		border: none;
		background: none;
		padding: 5px 10px;
		margin: none;
		color: #9C9C9C;
		&:active, &:focus {
			color: #333;
			outline: none;
			svg {
				fill: #333;
			}
		}
		svg {
			width: 16px;
			height: 16px;
			fill: #9C9C9C;
		}
		&:hover svg {
			fill: #333; 
		}
	}
  
  .sg-button__save:hover {
    svg {
      fill: #00E676;
    }
  }
  
  .sg-button__cancel:hover {
    svg {
      fill: #FF3D00;
    }
  }
	
	.sg-markuptoggle {
		svg {
			position: relative;
			top: 3px;
			margin-right: 5px;
		}
	}
	
	.sg-markuptext {
		color: #9C9C9C;
		font-style: italic;
		font-weight: 100;
	}
	
	.sg-container:hover .sg-actions {
		opacity: 1;
	}

	
	.sg-container:hover .sg-style-actions button {
		opacity: 1;
	}
	
	.sg-output {
		padding: 36px 0 0 0;
		margin: 1em 0;
	}
	
	.sg-confirm-style {
		position: absolute;
		background: #FF3D00;
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
		
		.sg-button {
			background: white;
			color: #FF3D00;
			border: 2px solid white;
			&:hover {
				background: #FF3D00;
				color: white;
			}
		}
	}
	
	.expand-transition {
  transition: all .3s ease;
	height: 100%;
  overflow: hidden;
}

.expand-enter, .expand-leave {
  height: 0;
  padding: 0 10px;
  opacity: 0;
}
}
</style>

<script>
import CodeEditor from './Editor.vue';
import Icon from './Icon.vue';
import { updateStyle, removeStyle } from '../common/actions.js';
export default {
  props: ['style', 'index', 'section'],
  
  vuex: {
    actions: {
      updateStyle: updateStyle,
      removeStyle: removeStyle
    }
  },
  
  data: function() {
    return {
      logged_in: styleguide_options.logged_in,
      showMarkup: false,
      editing: false,
      confirm: false,
      prev: {}
    }
  },
  
  created: function() {
    if( !this.style.title ) {
      this.editing = true;
    };
  },
  
  components: {
    CodeEditor,
		Icon
  },
	
  methods: {
		
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
    
    editStyle: function(evt) {
      this.updateStyle({
        title: this.style.title,
        html: this.style.html,
        id: this.style.id
      }, this.style);
      this.editing = false;
    },
		
		deleteStyle: function() {
			this.confirm = false;
      this.removeStyle( this.index, this.section, this.style.id )
		},
		
		toggleConfirm: function() {
			this.confirm = !this.confirm;
		}
  }
}
</script>