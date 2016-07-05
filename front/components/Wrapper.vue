<style lang="scss">
#styleguide {
	.sg-section {
		margin-bottom: 2em;
		padding-bottom: 1em;
		border-bottom: 1px dotted #ccc;
		position: relative;
    
    &.loading {
      opacity: 0.3;
    }
	}
  .sg-section-wrap {
    position: relative;
  }
	.sg-section-title {
		font-size: 24px;
		margin-bottom: 10px;
		font-weight: bold;
		background: #f7f7f7;
		border: none !important;
		display: block;
		width: 90%;
    padding: 10px;
		
		&:focus {
			background: white;
		}
	}
  
  .sg-section__actions {
    text-align: right;
  }
  .sg-section__confirm {
    width: 100%;
    position: absolute;
    left: 0;
    background: rgba(239,83,80 ,1);
    color: white;
    padding: 10px;
    z-index: 10;
    text-align: left;
  }
  .sg-confirm__buttons {
    display: inline-block;
    color: white;
    float: right;
    
    button {
      color: white !important;
      border: 1px solid white;
      padding: 5px 20px;
      &:hover {
        background: white;
        color: rgba(239,83,80 ,1) !important;
        
      }
    }
  }
  .sg-section__divide {
    padding: 7px 5px;
    display: inline-block;
  }
}
</style>

<template>
  <section id="{{section.slug }}" class="sg-section" v-bind:class="{'loading' : loading}">

		<div class="sg-section-wrap">
			<h3 class="sg-stack sg-section-title" v-if="!logged_in">{{ section.title }}</h3>
	    <input v-if="logged_in" class="sg-input sg-stack sg-font-dark sg-section-title" v-model="title" v-on:focus="enterEditing" v-on:blur="pushEdit" v-on:keyup.enter="pushEdit" />
		</div>
    <style v-for="style in section.styles" :style="style" :index="$index" :section="section"></style>
		
    <section class="sg-stack sg-section__actions" v-if="logged_in">
      <div v-if="confirm" class="sg-section__confirm">
        Are you sure? This will delete all styles in this section.
        <div class="sg-confirm__buttons">
          <button class="sg-button" v-on:click="removeSection">Yes</button>
          <button class="sg-button" v-on:click="toggleConfirm">No</button>
        </div>
      </div>
        <button v-on:click="pushStyle()" class="sg-button sg-button__add">
					<icon name="add"></icon>
					Add To Section
				</button>
        <span class="sg-section__divide"> | </span>
        <button class="sg-button" v-on:click="toggleConfirm">
          <icon name="delete"></icon>
          Delete
        </button>
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
    toggleConfirm: function() {
      this.confirm = !this.confirm;
    },
		removeSection: function() {
			this.deleteSection( this.section );
		}
  }
}
</script>