<template>
  <nav class="sg-nav sg-stack sg-col-3">
    <ul class="sg-nav-links sg-nav-container">
      <navlinks 
        v-for="section in sections"
        :title="section.title"
        :styles="section.styles"
        :slug="section.slug"
        :id="section.id"
        :active="active"
        ></navlinks>
        <li><button v-on:click="toggleSettings" class="sg-button">Settings</button></li>
    </ul>
  </nav>
</template>

<style lang="scss">
#styleguide {
  .sg-nav-container {
      position: fixed;
  }
  
	.sg-nav-links {
		list-style: none;
		margin: 0;
		padding: 1em;
		font-size: 13px;
		font-weight: normal;
	}
	
	.sg-nav-link {
		list-style: none;
		a {
			display: block;
			width: 100%;
			padding: 10px;
			box-sizing: border-box;
			border-radius: 5px;
		}
	}
	
	.sg-nav-sublinks {
		padding: 0;
		padding-left: 10px;
		font-size: 13px;
	}
	
	.sg-nav-link--link:hover, .sg-nav-link--link.selected {
		background: #eee;
	}
}
</style>

<script>
import Navlinks from './Navlinks.vue';
import { toggleSettings } from '../common/actions.js';
export default {
  vuex: {
    getters: {
      sections: function(state) {
        return state.sections;
      },
      show: function(state) {
        return state.show;
      }
    },
    actions:{
      toggleSettings: toggleSettings
    }
  },
  components: {
    Navlinks
  }
}
</script>