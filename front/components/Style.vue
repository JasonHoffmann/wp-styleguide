<template>
  <div class="sg-container">
    <input placeholder="Add a title..." type="text" class="sg-title" v-model="title" v-on:change="editTitle()" />
    <div class="sg-output">
        {{{ html }}}
    </div>
    <p>Example Code:</p>
    <div class="sg-markup">
      <pre v-prism-directive="html" contenteditable="" class="language-markup">{{ html }}</pre>
      <!-- <textarea placeholder="Enter your markup here..." v-on:keyup="editHtml() | debounce 500" v-model="html"></textarea> -->
    </div>
  </div>
</template>

<script>
var Prism = require('prismjs');
export default {
  props: {
    html: String,
    editing: Boolean,
    title: String,
    id: Number
  },
  
  methods: {
    updateStyle: function( obj ) {
      this.$http({ 
          url: styleguide_options.url + '/style/' + this.id,
          method: 'POST',
          data: obj
        });
    },
		
		watch: {
			html : function(val, oldval) {
			}
		},
    
    log: function() {
      console.log('log');
    },
    
    editTitle: function(title) {
      console.log(this);
      this.updateStyle({
        title: this.title
      })
    }
  }
}
</script>