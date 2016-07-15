<style lang="scss">
#styleguide {
  .sg-nav__container {
      position: fixed;
			width: 300px;
  }
  
	.sg-nav__links {
		list-style: none;
		margin: 0;
		padding: 0;
		font-size: 13px;
		font-weight: normal;
		
		.sg-nav__link {
			font-weight: bold;
		}
		
		&.m-children {
			.sg-nav-link {
				font-weight: normal;
			}
			a {
				padding-left: 20px;
			}
		}
	}
	
	.sg-nav__link {
		list-style: none;
		margin-bottom: 5px;
		a {
			display: block;
			width: 100%;
			padding: 4px 8px;
			border-left: 3px solid transparent;
			box-sizing: border-box;
			border-radius: 0;
			margin-bottom: 5px;
			
			&:hover, &.selected {
				border-color: #eee;
			}
		}
	}
	
	.sg-button__settings {
		margin-top: 20px;
	}

}
</style>

<template>
  <nav class="sg-nav sg-stack sg-col-3">
    <ul class="sg-nav__links sg-nav__container">
			<li v-for="section in sections" class="sg-nav__link">
					<a v-on:click="toggleActive(section)" v-bind:class="{ 'selected': section.selected }" href="#{{ section.slug }}">{{ section.title }}</a>
					<ul class="sg-nav__links m-children" v-show="section.selected">
						<li class="sg-nav__linkd" v-for="style in section.styles">
							<a href="#{{ style.slug }}">{{ style.title }}</a>
						</li>
					</ul>
			</li>
        <li v-if="logged_in"><button v-on:click="toggleSettings" class="sg-button sg-button__settings"><icon name="cog"></icon> Settings</button></li>
    </ul>
  </nav>
</template>

<script>
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  vuex: {
    getters: {
      sections: function(state) {
        return state.sections;
      },
			logged_in: function(state) {
				return state.logged_in;
			}
    },
    actions:{
      toggleSettings: actions.toggleSettings,
			toggleActive: actions.toggleActive
    }
  },
  components: {
		Icon
  }
}
</script>