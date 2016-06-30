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
        <li v-if="logged_in"><button v-on:click="toggleSettings" class="sg-button sg-button__settings"><icon name="cog"></icon> Settings</button></li>
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
	
	.sg-button__settings {
		svg {
			width: 14px;
			height: auto;
			fill: #333;
			margin-right: 2px;
			position: relative;
			top: 3px;
		}
		&:hover {
			color: #666 !important;
		}
		
		&:hover svg {
			fill: #666;
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
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  vuex: {
    getters: {
      sections: function(state) {
        return state.sections;
      },
      show: function(state) {
        return state.show;
      },
			logged_in: function(state) {
				return state.logged_in;
			}
    },
    actions:{
      toggleSettings: actions.toggleSettings
    }
  },
  components: {
    Navlinks,
		Icon
  }
}
</script>