<template>
  <section id="{{slug }}" class="sg-section">
    <div v-bind:id="slug"></div>			
      <input class="sg-stack sg-font-dark sg-section-title sg-style-title" v-on:change="editTitle()" v-model="title" />
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

<script>
var Style = require('./Style.vue');
export default {
  props: {
    title: String,
    id: Number,
    slug: String,
    styles: Array
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