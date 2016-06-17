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
        :slug="style.slug"
      ></style>
      <section class="sg-section sg-stack">
          <button v-on:click="addStyle()" class="sg-button">Add New Element</button>
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
	.sg-section-title {
		font-size: 32px;
		margin-bottom: 10px;
		font-weight: bold;
	}
}
</style>

<script>
var Style = require('./Style.vue');
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
  
  components: {
    Style
  },
  
  methods: {
		editTitle: function() {
			this.updateSection({
				title: this.title
			});
		},
		
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
        id: 0
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
      });
    }
  }
}
</script>