<template>
  <li class="sg-nav-link sg-nav-link__parent">
      <a v-on:click="switchSelected" class="sg-nav-link--link" v-bind:class="{ 'selected': selected }" href="#{{ slug }}">{{ title }}</a>
      <ul class="sg-nav-links sg-nav-sublinks" v-show="selected">
        <li class="sg-nav-link sg-nav-link__child" v-for="style in styles">
          <a class="sg-nav-link--link" href="#{{ style.slug }}">{{ style.title }}</a>
        </li>
      </ul>
  </li>
</template>

<script>
import Events from './events.js';
export default {
  props: {
    title: String,
    slug: String,
    styles: Array,
    selected: {
      default: false,
      type: Boolean
    }
  },
	
	created: function() {
		var self = this;
		Events.$on('nav-selected', function(slug) {
			if( self.slug === slug ) {
				self.selected = true;
			} else {
				self.selected = false;
			}
		})
	},
  
  methods: {
    switchSelected: function() {
			Events.$emit('nav-selected', this.slug);
    }
  }
}
</script>