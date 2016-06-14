<template>
  <div id="{{ slug }}" class="sg-container">
		<input 
					placeholder="Add a title..." 
					type="text" class="sg-style-title sg-stack sg-font-light" 
					v-model="title" 
					v-on:change="editTitle()"
					v-bind:class="{'editing' : editing }"
			/>
    <div class="sg-output">
        {{{ html }}}
    </div>
    <p>Example Code:</p>
    <div class="sg-markup">
      <pre v-prism-directive="html" contenteditable="" class="language-markup">{{ html }}</pre>
    </div>
  </div>
</template>

<script>
var Prism = require('prismjs');
var CodeEditor = require('./Editor.vue');
export default {
  props: {
    html: String,
    editing: Boolean,
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