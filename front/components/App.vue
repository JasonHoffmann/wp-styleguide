<style lang="scss">
#styleguide {
	.sg-wrap {
		transition: opacity 0.5s;
	}
	.loaded {
		opacity: 0;
	}
}
</style>

<template>
<div class="sg-wrap" v-bind:class="{'loaded' : !loaded}">
<div class="sg-row sg-main-content" v-if="onboarded">
	<settings v-if="showSettings"></settings>
	<navbar></navbar>
	<div class="sg-col-9">
		<wrapper v-for="section in sections" :section="section"></wrapper>
			<form class="sg-section-wrap sg-stack" v-on:submit="addWrapper" v-show="logged_in">
				<input type="text" class="sg-stack sg-font-dark sg-section-title" :placeholder="placeholder" />
				<button class="sg-button sg-actions sg-actions__section"><icon name="add"></icon> Add</button>
			</form>
		</div>
</div>

<div class="sg-row sg-main-content sg-stack sg-onboarding sg-settings-group" v-else>
	<onboard></onboard>
</div>
</div>
</template>

<script>
import Wrapper from './Wrapper.vue';
import Settings from './Settings.vue';
import Navbar from './Navbar.vue';
import Icon from './Icon.vue';
import Onboard from './Onboard.vue';
import store from '../common/store.js';
import actions from '../common/actions.js';
export default {
	
  el: '#app',
	
	store: store,
	
	vuex: {
		getters: {
			logged_in: function(state) {
				return state.logged_in;
			},
			sections: function(state) {
				return state.sections;
			},
			sectionPositions: function(state) {
				return state.sectionPositions;
			},
			showSettings: function(state) {
				return state.settings.show;
			},
			onboarded: function(state) {
				return state.settings.onboarded;
			},
			loaded: function(state) {
				return state.loaded;
			}
		},
		
		actions: {
			getAll: actions.getAll,
			addSection: actions.addSection,
			toggleActive: actions.toggleActive,
			addStyle: actions.addStyle
		}
	},
	
	computed: {
		placeholder: function() {
			if( this.sections.length < 1 ) {
				return 'Click Here to Add a Section';
			} else {
				return 'Add Section...';
			}
		}
	},
	
	components: {
		Wrapper,
		Settings,
		Navbar,
		Icon,
		Onboard
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
			
			var i = this.sections.length;
			var len = i + 1;
			var add = this.addSection({
				title: newTitle,
				order: len,
				id: 0,
				styles: []
			});
			
			console.log(this.sections[i]);

		}

  }
}
</script>