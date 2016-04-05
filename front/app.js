var Vue = require('vue');
var $ = require('jquery');

var app = new Vue({

  el: '#app',

  data: {
    style: {
      title: '',
      body: ''
    },
    styles: []
  },

  ready: function () {
    this.fetchStyles();
  },

  methods: {

    fetchStyles: function() {
      var styles = [];

      $.get(styleguide_options.url + '/wp-json/styles/style')
        .done(function(styles){
          this.$set('styles', styles);
          console.log(styles);
        })
        .fail(function (err) {
          console.log(err);
        });
    },

  }
});