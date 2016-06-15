<template>
  <div id="{{ slug }}" class="sg-container">
		<div class="sg-style-actions">
			<button class="sg-style-edit">Edit</button>
			<button class="sg-style-delete">Delete</button>
		</div>
		<h4 class="sg-style-title sg-stack" v-if="!editing">{{ title }}</h4>
		<input 
					placeholder="Add a title..." 
					type="text" class="sg-style-title sg-stack sg-font-light" 
					v-model="title" 
					v-on:change="editTitle()"
					v-bind:class="{'editing' : editing }"
					v-if="editing"
			/>
    <div class="sg-output">
        {{{ html }}}
    </div>
    <div class="sg-markup">
      <pre v-prism-directive="html" contenteditable="" class="language-markup">{{ html }}</pre>
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
	
	.sg-style-actions {
		position: absolute;
		right: 5px;
		top: 10px;
		button {
			border: 1px solid #ddd;
			background: none;
			color: #ddd;
			display: inline-block;
			padding: 21px 10px;
			right: 9999px;
			position: relative;
			margin-right: 5px;
			font-size: 4px;
			opacity: 0;
			
			&:after {
				font-family: 'Dashicons';
				border: 2px solid #ddd;
				border-radius: 50%;
				top: 0;
				padding-top: 2px;
				position: absolute;
				right: -9999px;
				width: 30px;
				text-align: center;
				height: 30px;
				font-size: 24px;
				font-weight: 100;
			}
			
			&:hover:after {
				background: #ddd;
			}
		}
	}
	
	.sg-style-edit:after {
		content: '\f464';
	}
	
	.sg-style-delete:after {
		content: '\f182';
	}
	
	.sg-container:hover .sg-style-actions button {
		opacity: 1;
	}
	
	.sg-style-title {
		margin: 0 0 10px 0;
		padding: 0 0 5px 0;
		width: 100%;
		font-weight: 100;
		text-transform: uppercase;
		font-style: italic;
	}
	
	.sg-output {
		padding: 36px 0 0 0;
		margin: 1em 0;
		border-bottom: 1px dashed #999;
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
    
    enterEditing: function(evt) {
      this.editing = true;
      this.prevTitle = this.title;
    },
    
    exitEditing: function(evt) {
      this.editing = false;
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