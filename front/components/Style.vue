<template>
  <div class="sg-container">
    <h2 class="sg-stack sg-font-light sg-style-title" v-on:dblclick="editable($event)">{{ title }}</h2>
    <!-- <div class="sg-edit-block">
      <input  class="sg-stack sg-font-light sg-style-title" 
              placeholder="Add a title..." 
              type="text" 
              v-on:submit="editTitle()"
              v-on:focus="enterEditing()"
              v-on:blur="exitEditing()"
              :value="title"
        />
        <button class="sg-stack sg-button sg-button__edit" 
                v-show="editing"
                v-on:click="editTitle()">
          Save
        </button>
        <button class="sg-stack sg-button sg-button__edit sg-button__cancel" 
                v-show="editing"
                v-on:click="cancelTitle()">
                Cancel</button>
      </div> -->
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
    id: Number
  },
  
  components: {
    CodeEditor
  },
  
  watch: {
    html : function(val, oldval) {
      this.updateStyle({ html: val });
    }
  },
  
  methods: {
    updateStyle: function( obj ) {
      this.$http({ 
          url: styleguide_options.url + '/style/' + this.id,
          method: 'POST',
          data: obj
        });
    }.debounce(300),
    
    editable: function(evt) {
      var self = this;
      this.$editable(evt, function(value) {
        self.updateStyle({title: value});
      })
    },
    
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