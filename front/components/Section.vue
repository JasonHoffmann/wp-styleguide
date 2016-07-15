<style lang="scss">
#styleguide {
	.sg-sct {
		margin-bottom: 2em;
		padding-bottom: 1em;
		border-bottom: 1px dotted $gray-lighter;
		position: relative;
    
    &.loading {
      opacity: 0.3;
    }
	}
	
  .sg-sct__wrap {
    position: relative;
  }
	
	.sg-sct__title {
		font-size: 24px;
		margin-bottom: 10px;
		font-weight: bold;
		background: $body-bg;
		border: none !important;
		display: block;
		width: 100%;
    padding: 10px;
		
		&:focus {
			background: white;
			border: none;
			
			& + .sg-sct__add {
				opacity: 1;
			}
		}
	}
	
	.sg-sct__loader {
		position: absolute;
		top: 24px;
		left: -20px;
	}
	
	.sg-sct__add {
		position: absolute;
		right: 10px;
		top: 10px;
		opacity: 0;
	}
	
	.sg-sct__delete {
		min-height: 14px;
		padding: 8px 16px;
	}
	
	.sg-sct__actions {
		text-align: right;
		opacity: 0.4;
		position: relative;
		transition: opacity 0.25s;

		&:hover {
			opacity: 1;
		}
		& .sg-sct__delete:hover {
			svg {
				fill: $red;
			}
		}
	}
	
	.sg-sct__divide {
		padding: 7px 5px;
		display: inline-block;
	}
	
	.sg-sct__confirm {
		position: absolute;
		right: 0;
		top: 0;
		background: $body-bg;
		padding-bottom: 5px;
	}
	
	.sg-sct__yes {
		&:hover {
			background: $green;
			svg {
				fill: $white;
			}
		}
	}

}
</style>

<template>
  <section id="{{section.slug }}" class="sg-sct" v-bind:class="{'loading' : loading}">
		<form class="sg-stack sg-sct__wrap" v-on:submit.prevent="pushEdit" v-if="logged_in">
			<input type="text" class="sg-stack sg-font-dark sg-sct__title" placeholder="Add a Section..." v-model="title" />
			<button class="sg-button sg-sct__add">Edit</button>
			<span class="sg-sct__loader"><icon name="load" v-if="loading"></icon></span>
		</form>
		<div class="sg-stack sg-sct__wrap" v-else>
			<h3 class="sg-stack sg-section-title" v-if="!logged_in">
				{{ section.title }}
			</h3>
		</div>
		
    <style v-for="style in section.styles" :style="style" :index="$index" :section="section"></style>
		
    <section class="sg-stack sg-sct__actions" v-if="logged_in">
			
      <button v-on:click="pushStyle()" class="sg-button sg-button__add">
				<icon name="add"></icon>
				Add Style
			</button>
      <button class="sg-button sg-sct__delete" v-on:click="toggleConfirm">
        <icon name="delete"></icon>
      </button>
			
			<div v-if="confirm" class="sg-sct__confirm">
				Are you sure?
				<button class="sg-button sg-sct__yes" v-on:click="removeSection"><icon name="save"></icon></button>
				<button class="sg-button sg-sct__no" v-on:click="toggleConfirm"><icon name="cancel"</button>
			</div>
    </section>
			
  </section>
</template>

<script>
import Style from './Style.vue';;
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  props: ['section'],
  
  data: function() {
    return {
      editing: false,
      confirm: false
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
		},
    
    loading: function() {
      if( this.section.id === 0 ) {
        return true;
      } else {
        return false;
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
    pushStyle: function() {
      var newStyle = {
        title: '',
        html: '<!-- insert your code here -->',
        id: 0
      };
      this.addStyle( newStyle, this.section );
    },
		
		pushUpdate: function(val) {
			this.updateSection(val, this.section);
		}.debounce(300),
		
		pushEdit: function() {
			this.editSection(this.title, this.section);
		},
    toggleConfirm: function() {
      this.confirm = !this.confirm;
    },
		removeSection: function() {
			this.deleteSection( this.section );
		}
  }
}
</script>