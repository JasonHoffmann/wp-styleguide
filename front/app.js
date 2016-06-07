var Vue = require('vue');
Vue.use(require('vue-resource'));
var Wrapper = require('./components/Wrapper.vue');
var Prism = require('prismjs');
var Editor = require('./components/Editor.vue');
var VueEditable= require('./plugins/vue-editable.js');
Vue.use(VueEditable);

var app = new Vue({
	
  el: '#app',

  data: {
		all_sections: [],
		sections: [],
		adding: false
  },
	
	components: {
		Wrapper
	},

  ready: function () {
    this.fetchStyles();
  },

  methods: {
		
    fetchStyles: function() {
			var resource = this.$resource(styleguide_options.url + '/section/{id}');
			resource.get()
			.then(function( response) {
				this.sections = response.data;
				console.log(response.data);
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
    },
		
		addWrapper: function(evt) {
			evt.preventDefault();
			var newTitle = evt.target[0].value;
			evt.target[0].value = '';
			var len = this.all_sections.push({
				title: newTitle,
				id: 0,
				styles: []
			});
			var nl = len - 1;
			
			
			this.$http({
				method: 'POST',
				url: styleguide_options.url + '/section',
				data: {
					title : newTitle,
					order: len
				}
			}).then(function(response) {
				this.all_sections[nl].id = response.data.id.term_id;
			});
			
			
		}

  }
});

Vue.directive('prism-directive', Editor );

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});