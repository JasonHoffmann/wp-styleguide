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
import { toggleActive } from '../common/actions.js';

export default {
  props: {
    title: String,
    slug: String,
    styles: Array,
    id: Number
  },
  
  data: function() {
    return {
      selected: false
    }
  },
  
  vuex: {
    getters: {
      active: function(state) {
        return state.activeSection;
      }
    },
    actions : {
      toggleActive: toggleActive
    }
  },
  
  watch: {
    'active' : function(val) {
      if(val.id === this.id) {
        this.selected = true;
      } else {
        this.selected = false;
      }
    }
  },
  
  methods: {
    switchSelected: function() {
      this.toggleActive({ id: this.id });
    }
  }
}
</script>