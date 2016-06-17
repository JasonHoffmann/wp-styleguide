<template>
  <div id="{{ slug }}" class="sg-container">
		<h4 class="sg-style-title sg-stack" v-show="!editing">
			{{ title }}
		</h4>
			<span v-show="!editing" class="sg-actions">
			<button v-on:click="enterEditing" class="sg-button__action">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
					 viewBox="0 0 50 50">
					 <path class="st0" d="M47.8,2.2C46.4,0.8,44.5,0,42.6,0s-3.9,0.8-5.3,2.2L5.4,34.1c-0.1,0.1-0.2,0.3-0.3,0.5l-5,13.8
					c-0.2,0.5-0.1,1,0.3,1.3C0.6,49.9,0.9,50,1.2,50c0.1,0,0.3,0,0.4-0.1l13.8-5c0.2-0.1,0.3-0.2,0.5-0.3l31.9-31.9
					c1.4-1.4,2.2-3.3,2.2-5.3S49.2,3.6,47.8,2.2L47.8,2.2z M14.3,42.7l-11,4l4-11L35,8l7,7C42,15,14.3,42.7,14.3,42.7z M46,10.9
					l-2.2,2.2l-7-7L39.1,4C40,3,41.2,2.5,42.6,2.5S45.1,3,46,4c0.9,0.9,1.4,2.2,1.4,3.5S47,10,46,10.9L46,10.9z"/>
				</svg>
			</button>
			<button class="sg-button__action">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
				 viewBox="0 0 50 50">
				<g>
					<path class="st2" d="M40.5,5h-8.8V3.8C31.8,1.7,30.1,0,28,0h-5c-2.1,0-3.8,1.7-3.8,3.8V5h-8.8C8.4,5,6.8,6.7,6.8,8.8v2.5
					c0,1.6,1,3,2.5,3.5v31.5c0,2.1,1.7,3.8,3.8,3.8h25c2.1,0,3.8-1.7,3.8-3.8V14.8c1.5-0.5,2.5-1.9,2.5-3.5V8.7C44.2,6.7,42.6,5,40.5,5
					z M21.8,3.8c0-0.7,0.6-1.2,1.2-1.2h5c0.7,0,1.2,0.6,1.2,1.2V5h-7.5V3.8z M38,47.5H13c-0.7,0-1.2-0.6-1.2-1.2V15h27.5v31.2
					C39.2,46.9,38.7,47.5,38,47.5z M41.8,11.2c0,0.7-0.6,1.2-1.2,1.2h-30c-0.7,0-1.2-0.6-1.2-1.2V8.8c0-0.7,0.6-1.2,1.2-1.2h30
					c0.7,0,1.2,0.6,1.2,1.2V11.2z"/>
					<path class="st2" d="M33,17.5c-0.7,0-1.2,0.6-1.2,1.2v25c0,0.7,0.6,1.2,1.2,1.2s1.2-0.6,1.2-1.2v-25C34.2,18.1,33.7,17.5,33,17.5z"
					/>
					<path class="st2" d="M25.5,17.5c-0.7,0-1.2,0.6-1.2,1.2v25c0,0.7,0.6,1.2,1.2,1.2s1.2-0.6,1.2-1.2v-25
					C26.8,18.1,26.2,17.5,25.5,17.5z"/>
					<path class="st2" d="M18,17.5c-0.7,0-1.2,0.6-1.2,1.2v25c0,0.7,0.6,1.2,1.2,1.2s1.2-0.6,1.2-1.2v-25C19.2,18.1,18.7,17.5,18,17.5z"
					/>
				</g>
			</svg>	
		</button>
		</span>
		<input 
					placeholder="Add a title..." 
					type="text" class="sg-style-title sg-stack sg-font-light" 
					v-model="title" 
					v-on:change="editTitle()"
					v-bind:class="{'editing' : editing }"
					v-show="editing"
					autofocus
			/>
    <div class="sg-output">
        {{{ html }}}
    </div>
		<div class="sg-markuptoggle">
			<button class="sg-button__action" v-on:click="toggleMarkup" v-show="!editing">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
					 viewBox="0 0 50 25">
						<g id="Layer_3">
							<path class="st2" d="M11.8,24c-0.3,0-0.7-0.1-0.9-0.4L0.7,13.4c-0.5-0.5-0.5-1.3,0-1.8L10.9,1.3c0.5-0.5,1.3-0.5,1.8,0
							s0.5,1.3,0,1.8l-9.3,9.3l9.3,9.3c0.5,0.5,0.5,1.3,0,1.8C12.5,23.9,12.2,24,11.8,24L11.8,24z"/>
							<path class="st2" d="M37.5,24c-0.3,0-0.7-0.1-0.9-0.4c-0.5-0.5-0.5-1.3,0-1.8l9.3-9.3l-9.3-9.3c-0.5-0.5-0.5-1.3,0-1.8
							s1.3-0.5,1.8,0l10.3,10.3c0.5,0.5,0.5,1.3,0,1.8L38.4,23.7C38.1,23.9,37.8,24,37.5,24L37.5,24z"/>
							<path class="st2" d="M18.2,24c-0.2,0-0.5-0.1-0.7-0.2c-0.6-0.4-0.8-1.2-0.4-1.8L30,1.6c0.4-0.6,1.2-0.8,1.8-0.4
							c0.6,0.4,0.8,1.2,0.4,1.8L19.3,23.4C19.1,23.8,18.7,24,18.2,24z"/>
					</g>
				</svg>
			</button>
			<span v-show="editing" class="sg-markuptext">Edit the HTML below</span>
		</div>
    <div class="sg-markup" v-if="showMarkup">
      <pre v-prism-directive="html" :contenteditable="editing" class="language-markup">{{ html }}</pre>
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
		top: 16px;
		right: 10px;
		opacity: 0;
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
	
	.sg-style-title {
		margin: 0 0 10px 0;
		padding: 0 0 5px 0;
		width: 100%;
		font-weight: bold;
		font-size: 24px;
	}
	
	.sg-output {
		padding: 36px 0 0 0;
		margin: 1em 0;
	}
}
</style>

<script>
var Prism = require('prismjs');
var CodeEditor = require('./Editor.vue');
export default {
  props: {
    html: String,
		editing: {
			default: false,
			type: Boolean
		},
		showMarkup: {
			default: false,
			type: Boolean
		},
    title: String,
    prevTitle: String,
    id: Number,
    slug: String
  },
  
  components: {
    CodeEditor
  },
  
  watch: {
    html : function(val, oldval) {
      this.updateStyle({ html: val });
    }.debounce(500)
  },
  
  methods: {
    updateStyle: function( obj ) {
      this.$http({ 
          url: styleguide_options.url + '/styles/' + this.id,
          method: 'POST',
					headers: {
						'X-WP-Nonce' : styleguide_options.nonce
					},
          data: obj
        });
    }.debounce(300),
		
		toggleMarkup: function() {
			this.showMarkup = !this.showMarkup
		},
    
    enterEditing: function(evt) {
      this.editing = true;
			this.showMarkup = true;
    },
    
    exitEditing: function(evt) {
      this.editing = false;
			this.showMarkup = false;
    },
    
    editTitle: function(evt) {
      this.exitEditing();
      this.updateStyle({
        title: this.title
      })
    },
    
    cancelTitle: function() {
      this.title = this.prevTitle;
      this.exitEditing();
    }
  }
}
</script>