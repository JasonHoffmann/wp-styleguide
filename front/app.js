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
			this.$http({
				method: 'GET',
				url: styleguide_options.url + '/data',
			}).then(function(response) {
				var sections = response.data.sections;
				this.all_sections = sections;
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
				url: styleguide_options.url + '/sections',
				data: {
					title : newTitle,
					order: len
				}
			}).then(function(response) {
				console.log(response);
				this.all_sections[nl].id = response.data.id;
			});
			
			
		}

  }
});

Vue.directive('prism-directive', Editor );

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});