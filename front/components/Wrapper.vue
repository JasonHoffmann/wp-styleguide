<template>
  <section id="{{slug }}" class="sg-section">
    <div v-bind:id="slug"></div>
			<h3 class="sg-stack sg-section-title" v-if="!editing">{{ title }}</h3>
      <input v-if="editing" class="sg-stack sg-font-dark sg-section-title sg-style-title" v-on:change="editTitle()" v-model="title" />
      <style 
        v-for="style in styles"
        :title="style.title"
        :id="style.id"
        :html="style.html"
        :slug="style.slug",
        :editing.once="style.editing"
				:show-markup.once="style.showMarkup"
      ></style>
      <section class="sg-section sg-stack sg-section__add" v-show="logged_in">
          <button v-on:click="addStyle()" class="sg-button sg-button__add">
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
import Style from './Style.vue';
import Events from './events.js';
import Icon from './Icon.vue';
export default {
  props: {
    title: String,
    id: Number,
    slug: String,
    styles: Array,
		editing: {
			default: false,
			type: Boolean
		}
  },
	
	ready: function() {
		if( this.$el ) {
			var pos = this.$el.getBoundingClientRect().top + window.scrollY -
				parseInt(getComputedStyle(this.$el).marginTop, 10);
				console.log(pos);
		}
		Events.$options.sectionPositions.push(pos);
		Events.$options.sections.push(this.slug);
	},
  
  data: function() {
    return {
      logged_in: styleguide_options.logged_in
    }
  },
  
  components: {
    Style,
		Icon
  },
  
  methods: {
		
		updateSection: function( obj ) {
			this.$http({ 
					url: styleguide_options.url + '/sections/' + this.id,
					method: 'POST',
					data: obj
				});
		}.debounce(300),
		
    addStyle: function() {
      var len = this.styles.push({
        title: '',
        html: '',
        id: 0,
				editing: true,
				showMarkup: true
      });
      var len = len - 1;
			
      this.$http({
        method: 'POST',
        url: styleguide_options.url + '/styles',
				headers: {
					'X-WP-Nonce' : styleguide_options.nonce
				},
        data: {
          section_id : this.id
        }
      }).then(function(response) {
        this.styles[len].id = response.data.id;
				this.styles.$set(len, { editing: true });
      });
    }
  }
}
</script>