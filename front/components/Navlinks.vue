<template>
  <li class="sg-nav-link sg-nav-link__parent">
      <a v-on:click="switchSelected" class="sg-nav-link--link" href="#{{ slug }}">{{ title }}</a>
      <ul class="sg-nav-links sg-nav-sublinks" v-show="selected">
        <li class="sg-nav-link sg-nav-link__child" v-for="style in styles">
          <a class="sg-nav-link--link" href="#{{ style.slug }}">{{ style.title }}</a>
        </li>
      </ul>
  </li>
</template>

<script>
var bus = require('./bus.js');
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
  
  ready: function() {
    console.log(bus);
  },
  
  methods: {
    switchSelected: function() {
      this.selected = !this.selected;
    }
  }
}
</script>