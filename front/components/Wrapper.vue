<template>
  <section id="{{section.slug }}" class="sg-section">
    <div v-bind:id="slug"></div>
			<h3 class="sg-stack sg-section-title" v-if="!editing">{{ section.title }}</h3>
      <input v-if="editing" class="sg-stack sg-font-dark sg-section-title sg-style-title" v-on:change="editTitle()" v-model="title" />
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
	}
	.sg-section__add {
		text-align: right;
	}
	.sg-section-title {
		font-size: 32px;
		margin-bottom: 10px;
		font-weight: bold;
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
import { addStyle, addSectionPositions } from '../common/actions.js';
export default {
  props: ['section'],
  
  data: function() {
    return {
      editing: false
    }
  },
  
  vuex: {
    getters: {
      logged_in: function(state) {
        return state.logged_in
      }
    },
    actions: {
      addStyle: addStyle,
      addSectionPositions: addSectionPositions
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
        html: '',
        id: 0
      };
      this.addStyle( newStyle, this.section );
    }
  }
}
</script>