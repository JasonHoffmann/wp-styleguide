<style lang="scss">
#styleguide {
	background: #f7f7f7;
	&:before, &:after {
		width: auto;
		height: auto;
	}
	
	#app {
		max-width: 90%;
		margin: 0 auto;
	}
	
	// Global
	.sg-main-content {
		max-width: 1300px;
		margin: 2em auto 0 auto;
	}
	
	.sg-stack {
		font-family: ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Helvetica Neue", "Lucida Grande", sans-serif;
		color: #333;
		box-sizing: border-box;
		font-size: 16px;
		
		a {
			color: #666;
		}
	} 
	
	.sg-button {
		text-transform: uppercase;
		border: none;
		background: none;
		font-weight: 700;
		padding: 10px 0;
		border-radius: 3px;
		color: #333 !important;
	}
	
	/*
	Grid
	*/
	.container {
		margin: 0 auto;
		width: 80%;
	}

	.container-fluid {
		margin: 0 auto;
		width: 100%;
	}

	.sg-row:before,
	.sg-row:after {
	  display: table;
	  line-height: 0;
	  content: "";
	}

	.sg-row:after {
	  clear: both;
	}

	.sg-col-1, .sg-col-2, .sg-col-3, .sg-col-4, .sg-col-5, .sg-col-6,
	.sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11, .sg-col-12,
	.sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4, .sg-col-offset-5, .sg-col-offset-6,
	.sg-col-offset-7, .sg-col-offset-8, .sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
	    float: left;
	    min-height: 1px;
	 }

	.box {
		padding: 20px;
	}

	.box-margin {
		margin: 0 10px 0 10px;
	}

	.sg-col-1, .sg-col-offset-1 {
		width: 8.33333333333%;
	}

	.sg-col-2, .sg-col-offset-2 {
		width: 16.6666666666%;
	}

	.sg-col-3, .sg-col-offset-3 {
		width: 24.9999999999%;
	}

	.sg-col-4, .sg-col-offset-4 {
		width: 33.3333333333%;
	}

	.sg-col-5, .sg-col-offset-5 {
		width: 41.6666666666%;
	}

	.sg-col-6, .sg-col-offset-6 {
		width: 49.9999999999%;
	}

	.sg-col-7, .sg-col-offset-7 {
		width: 58.3333333333%;
	}

	.sg-col-8, .sg-col-offset-8 {
		width: 66.6666666666%;
	}

	.sg-col-9, .sg-col-offset-9 {
		width: 74.9999999999%;
	}

	.sg-col-10, .sg-col-offset-10 {
		width: 83.3333333333%;
	}

	.sg-col-11, .sg-col-offset-11 {
		width: 91.6666666666%;
	}

	.sg-col-12, .sg-col-offset-12 {
		width: 100%;
	}

	@media only screen and (max-width : 768px) and (min-width : 480px) {
		/*
			Grid
		*/
		.container {
			width: 96%;
		}

		.sg-col-1, .sg-col-2, .sg-col-3, .sg-col-5, .sg-col-6,
		.sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11 {
	    	width: 50%;
	 	}

	 	.sg-col-4 {
			width: 33.3333333333%;
		}

	 	.sg-col-12 {
	 		width:100%;
	 	}

	 	.sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4,
	 	.sg-col-offset-5, .sg-col-offset-6, .sg-col-offset-7, .sg-col-offset-8,
	 	.sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
	 		width: 0% !important;
	 		display: none;
	 	}

	 	.box-margin {
			margin: 0 10px 0 10px;
		}
	}

	@media only screen and (max-width : 479px) {
		/*
			Grid
		*/
		.container {
			width: 96%;
		}

		.sg-col-1, .sg-col-2, .sg-col-3, .sg-col-4, .sg-col-5, .sg-col-6,
		.sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11, .sg-col-12 {
	    	float: none;
	    	width: 100%;
	 	}

	 	.sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4,
	 	.sg-col-offset-5, .sg-col-offset-6, .sg-col-offset-7, .sg-col-offset-8,
	 	.sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
	 		width: 0% !important;
	 		display: none;
	 	}

	 	.box-margin {
			margin: 0 10px 0 10px;
		}
	}
	
	.sg-styles-icon {
		position: relative;
		top: 8px;
		margin: 0 2px;
		svg {
			height: 32px;
		}
	}
}

</style>

<template>
<div class="sg-row sg-main-content" v-if="onboarded">
	<settings v-if="showSettings"></settings>
	<navbar></navbar>
	<div class="sg-col-9">
		<wrapper v-for="section in sections" :section="section"></wrapper>
			<form class="sg-section-title__edit" v-on:submit="addWrapper" v-show="logged_in">
				<input type="text" class="sg-stack sg-font-dark sg-section-title sg-style-title" placeholder="New Section Title" />
				<button class="sg-button">Add</button>
			</form>
		</div>
</div>

<div class="sg-row sg-main-content sg-stack sg-onboarding" v-else>
	<h3 class="sg-style-title">Welcome to <span class="sg-styles-icon"><icon name="styles"></icon></span>, a plugin for quickly building front-end styleguides.</h3>
	<p>Let's start by setting a few things up.</p>
	
</div>
</template>

<script>
import Wrapper from './Wrapper.vue';
import Settings from './Settings.vue';
import Navbar from './Navbar.vue';
import Icon from './Icon.vue';
import store from '../common/store.js';
import actions from '../common/actions.js';
export default {
	
  el: '#app',
	
	store: store,
	
	vuex: {
		getters: {
			logged_in: function(state) {
				return state.logged_in
			},
			sections: function(state) {
				return state.sections
			},
			sectionPositions: function(state) {
				return state.sectionPositions
			},
			showSettings: function(state) {
				return state.settings.show;
			},
			onboarded: function(state) {
				return state.settings.onboarded
			}
		},
		
		actions: {
			getAll: actions.getAll,
			addSection: actions.addSection,
			toggleActive: actions.toggleActive
		}
	},
	
	components: {
		Wrapper,
		Settings,
		Navbar,
		Icon
	},

  ready: function () {
		this.getAll();
		
		var self = this;
		window.addEventListener('scroll', function() {
			var y = window.scrollY;
			if (window.innerHeight + window.scrollY >= document.body.scrollHeight) {
				var last = self.sections.length - 1;
				var id = self.sections[last].id;
				self.toggleActive({ id: id });
			} else {
				for (var i = 0; i < self.sections.length; i++) {
					if (y >= self.sectionPositions[i] &&
							(self.sectionPositions[i+1] ? y < self.sectionPositions[i+1] : true)) {
								self.toggleActive({id: self.sections[i].id});
					}
				}
			}
		});
  },
	
  methods: {
		
		addWrapper: function(evt) {
			evt.preventDefault();
			
			var newTitle = evt.target[0].value;
			evt.target[0].value = '';
			var len = this.sections.length + 1;
			this.addSection({
				title: newTitle,
				order: len,
				id: 0,
				styles: [],
			});
		}

  }
}
</script>