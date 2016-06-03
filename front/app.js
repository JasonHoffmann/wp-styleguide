var Vue = require('vue');
Vue.use(require('vue-resource'));
var Wrapper = require('./components/Wrapper.vue');
var Prism = require('prismjs');
var Editor = require('./components/Editor.vue');
// import Section from './components/Section.vue';

var app = new Vue({
	
  el: '#app',

  data: {
		all_sections: [],
		sections: []
  },
	
	components: {
		Wrapper
	},

  ready: function () {
    this.fetchStyles();
  },

  methods: {
		
    fetchStyles: function() {
			var resource = this.$resource(styleguide_options.url + '/sections/{id}');
			resource.get()
			.then(function( response) {
				this.sections = response.data;
				for( var i = 0; i < this.sections.length; i++ ) {
					resource.get({ id: this.sections[i].id } )
					.then(function(response) {
						this.all_sections.push({
							id: response.data.id,
							title: response.data.name,
							slug: response.data.slug,
							styles: response.data.posts
						});
					});
				}
			}, function(response) {
				// TODO: error response
			}); 
    }

  }
});

Vue.directive('prism-directive', Editor );

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});