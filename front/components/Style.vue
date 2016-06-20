<template>
  <div id="{{ slug }}" class="sg-container">
		<h4 class="sg-style-title sg-stack" v-show="!editing">
			{{ title }}
		</h4>
			<span v-show="!editing && logged_in" class="sg-actions">
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
					v-bind:class="{'editing' : editing }"
					v-show="editing"
					autofocus
			/>
      <span v-show="editing" class="sg-actions sg-actions--editing">
      <button class="sg-button__action sg-button__save" v-on:click="editStyle">
        <svg viewBox="0 0 19 19" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title>Save</title>
                <g>
                    <path d="M9.5,19 C6.962,19 4.577,18.012 2.782,16.218 C0.987,14.424 0,12.038 0,9.501 C0,6.963 0.988,4.578 2.782,2.783 C4.576,0.988 6.962,1.33226763e-15 9.5,1.33226763e-15 C12.038,1.33226763e-15 14.423,0.988 16.218,2.783 C18.013,4.578 19,6.963 19,9.501 C19,12.039 18.012,14.424 16.218,16.218 C14.424,18.012 12.038,19 9.5,19 L9.5,19 Z M9.5,1 C4.813,1 1,4.813 1,9.5 C1,14.187 4.813,18 9.5,18 C14.187,18 18,14.187 18,9.5 C18,4.813 14.187,1 9.5,1 L9.5,1 Z" id="Shape"></path>
                    <path d="M7.5,13.5 C7.372,13.5 7.244,13.451 7.146,13.354 L4.146,10.354 C3.951,10.159 3.951,9.842 4.146,9.647 C4.341,9.452 4.658,9.452 4.853,9.647 L7.499,12.293 L14.145,5.647 C14.34,5.452 14.657,5.452 14.852,5.647 C15.047,5.842 15.047,6.159 14.852,6.354 L7.852,13.354 C7.754,13.452 7.626,13.5 7.498,13.5 L7.5,13.5 Z" id="Shape"></path>
                </g>
        </svg>
      </button>
      <button class="sg-button__action sg-button__cancel" v-on:click="exitEditing">
        <svg viewBox="0 0 19 19" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <title>Cancel</title>
            <g>
                <path d="M14.332,13.126 L10.252,9.5 L14.332,5.874 C14.538,5.691 14.557,5.375 14.374,5.168 C14.191,4.961 13.875,4.943 13.668,5.126 L9.5,8.831 L5.332,5.126 C5.126,4.943 4.81,4.961 4.626,5.168 C4.442,5.375 4.461,5.69 4.668,5.874 L8.748,9.5 L4.668,13.126 C4.462,13.309 4.443,13.625 4.626,13.832 C4.725,13.943 4.862,14 5,14 C5.118,14 5.237,13.958 5.332,13.874 L9.5,10.169 L13.668,13.874 C13.763,13.959 13.882,14 14,14 C14.138,14 14.275,13.943 14.374,13.832 C14.557,13.626 14.539,13.31 14.332,13.126 L14.332,13.126 Z" id="Shape"></path>
                <path d="M9.5,19 C6.962,19 4.577,18.012 2.782,16.218 C0.987,14.424 0,12.038 0,9.501 C0,6.963 0.988,4.578 2.782,2.783 C4.576,0.988 6.962,1.33226763e-15 9.5,1.33226763e-15 C12.038,1.33226763e-15 14.423,0.988 16.218,2.783 C18.013,4.578 19,6.963 19,9.501 C19,12.039 18.012,14.424 16.218,16.218 C14.424,18.012 12.038,19 9.5,19 L9.5,19 Z M9.5,1 C4.813,1 1,4.813 1,9.5 C1,14.187 4.813,18 9.5,18 C14.187,18 18,14.187 18,9.5 C18,4.813 14.187,1 9.5,1 L9.5,1 Z" id="Shape"></path>
            </g>
        </svg>	
    </button>
  </span>
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
		top: 24px;
		right: 10px;
		opacity: 0;
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
    slug: String,
    prev: {
      default: function() {
        return {}
      },
      type: Object
    }
  },
  
  data: function() {
    return {
      logged_in: styleguide_options.logged_in
    }
  },
  
  components: {
    CodeEditor
  },
  
  watch: {
    // html : function(val, oldval) {
    //   this.updateStyle({ html: val });
    // }.debounce(500)
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
      console.log(this.prev);
      this.prev = {
        title: this.title,
        html: this.html
      }
    },
    
    exitEditing: function(evt) {
      this.editing = false;
			this.showMarkup = false;
      this.title = this.prev.title;
      this.html = this.prev.html
    },
    
    editStyle: function(evt) {
      this.updateStyle({
        title: this.title,
        html: this.html
      });
      this.editing = false;
      this.showMarkup = false;
    }
  }
}
</script>