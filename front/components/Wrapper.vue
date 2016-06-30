<template>
  <section id="{{section.slug }}" class="sg-section">
		
		<div class="sg-section-wrap">
			<h3 class="sg-stack sg-section-title" v-if="!logged_in">{{ section.title }}</h3>
	    <input v-if="logged_in" class="sg-stack sg-font-dark sg-section-title" v-model="title" v-on:focus="enterEditing" v-on:blur="pushEdit" v-on:keyup.enter="pushEdit" />
			
			<span v-on:click="removeSection" v-show="logged_in && editing" class="sg-actions sg-actions__section">
				<button class="sg-button__action">
					<icon name="delete"></icon>
				</button>
			</span>
		</div>
		
    <style v-for="style in section.styles" :style="style" :index="$index" :section="section"></style>
		
    <section class="sg-section sg-stack sg-section__add" v-show="logged_in">
        <button v-on:click="pushStyle()" class="sg-button sg-button__add">
					<icon name="add"></icon>
					Add New Element
				</button>
    </section>
			
  </section>
</template>

<style lang="scss">
#styleguide {
	.sg-section {
		margin-bottom: 2em;
		padding-bottom: 1em;
		border-bottom: 1px dotted #ccc;
		position: relative;
	}
	.sg-actions__section {
		opacity: 1 !important;
		top: 10px !important;
		
	}
	.sg-section__add {
		text-align: right;
	}
	.sg-section-title {
		font-size: 32px;
		margin-bottom: 10px;
		font-weight: bold;
		background: #f7f7f7;
		border: none !important;
		display: block;
		width: 100%;
		
		&:focus {
			background: white;
		}
	}
	.sg-button__add {
		color: #333;
		font-weight: 700;
		svg {
			width: 14px;
			height: auto;
			fill: #333;
			position: relative;
			top: 2px;
			margin-right: 2px;
		}
		&:hover {
			color: #666;
			svg {
				fill: #666;
			}
		}
	}
}
</style>

<script>
import Style from './Style.vue';;
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  props: ['section'],
  
  data: function() {
    return {
      editing: false
    }
  },
	
	computed: {
		title: {
			get: function() {
				return this.section.title;
			},
			set: function(val) {
				this.pushUpdate(val);
			}
		}
	},
  
  vuex: {
    getters: {
      logged_in: function(state) {
        return state.logged_in
      }
    },
    actions: {
      addStyle: actions.addStyle,
      addSectionPositions: actions.addSectionPositions,
			deleteSection: actions.deleteSection,
			updateSection: actions.updateSection,
			editSection: actions.editSection
    }
  },
	
	ready: function() {
		if( this.$el ) {
			var pos = this.$el.getBoundingClientRect().top + window.scrollY -
				parseInt(getComputedStyle(this.$el).marginTop, 10);
      this.addSectionPositions(pos);
		}
	},
  
  components: {
    Style,
		Icon
  },
  
  methods: {
		enterEditing: function() {
			this.editing = true;
		},
    pushStyle: function() {
      var newStyle = {
        title: '',
        html: '',
        id: 0
      };
      this.addStyle( newStyle, this.section );
    },
		
		pushUpdate: function(val) {
			this.updateSection(val, this.section);
		}.debounce(300),
		
		pushEdit: function() {
			this.editing = false;
			this.editSection(this.title, this.section);
		},
		removeSection: function() {
			this.deleteSection( this.section );
		}
  }
}
</script>