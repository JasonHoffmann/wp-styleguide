<template>
  <section class="sg-section">			
      <h2 class="sg-stack sg-font-dark sg-section-title">{{ title }}</h2>
      <style 
        v-for="style in styles"
        :title="style.title"
        :id="style.id"
        :html="style.html"
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
    styles: Array
  },
  
  components: {
    Style
  },
  
  methods: {
    addStyle: function() {
      var len = this.styles.push({
        title: '',
        html: '',
        id: 0
      });
      
      var len = len - 1;
      console.log(this);
      
      this.$http({
        method: 'POST',
        url: styleguide_options.url + '/style',
        data: {
          section_id : this.id
        }
      }).then(function(response) {
        this.styles[len].id = response.data.id;
        // this.$set(this.styles[len].id, 15);
      });
    }
  }
}
</script>