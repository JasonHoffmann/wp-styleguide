var Vue = require('vue');
Vue.use(require('vue-resource'));

var app = new Vue({
	
  el: '#app',

  data: {
		all_sections: [{
			title: '',
			slug: '',
			styles: []
		}],
		sections: []
  },

  ready: function () {
    this.fetchStyles();
  },

  methods: {

    fetchStyles: function() {
			this.$http({url: styleguide_options.url + '/wp-json/styles/sections'})
			.then(function( response) {
				this.all_sections = [];
				this.sections = response.data;
				for( var i = 0; i < this.sections.length; i++ ) {
					this.$http({url: styleguide_options.url + '/wp-json/styles/sections/' + this.sections[i].id} ).then(function(response) {
						this.all_sections.push({
							title: response.data.name,
							slug: response.data.slug,
							styles: response.data.posts
						});
					})
				}
			}, function(response) {
				
			}); 
    },
		
		getSections: function( arr ) {
			var newarr = [];
			for( var i=0; i < arr.length; i++ ) {
				console.log( arr[i] );
			}
		}

  }
});