var Vue = require('vue');
Vue.use(require('vue-resource'));
var Wrapper = require('./components/Wrapper.vue');
var ajax = require('reqwest');
var Prism = require('prismjs');
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
					})
				}
			}, function(response) {
				// TODO: error response
			}); 
    }

  }
});



Vue.filter('prism', function(value) {
	return Prism.highlight(value, Prism.languages.markup);
});

Vue.directive('prism-directive', {
	state: {
		ss: '',
		se: '',
		before: '',
		after: '',
		selection: ''
	},
	bind: function() {
		var self = this;
		// this.el.contentEditable = true;
		$u.event.bind(this.el, {
			keydown: function(evt) {
				switch(evt.keyCode) {
					case 8:
						break;
					case 13:
						self.action('newline');
						break;
				}
			}
		});
	},
	
	action: function(action, options) {
		options = options || {};
		var pre = this.el,
		text = pre.textContent,
		ss = options.start || pre.selectionStart,
		se = options.end || pre.selectionEnd;
		this.state = {
				ss: ss,
				se: se,
				before: text.slice(0, ss),
				after: text.slice(se),
				selection: text.slice(ss,se)
			};
		console.log(this.state);
		var textAction = this.actions[action](this.state, options);
		var textContent = this.state.before + this.state.selection + this.state.after;
		console.log(this.state);
	},
	
	actions: {
		newline: function(state) {
			console.log(state);
			this.state.ss = 49;
			// var ss = state.ss,
			// 		lf = state.before.lastIndexOf('\n') + 1,
			// 		indent = (state.before.slice(lf).match(/^\s+/) || [''])[0];
			// 
			// state.before += '\n' + indent;
			// 
			// var selection = state.selection;
			// state.selection = '';	
			// 
			// state.ss += indent.length + 1;
			// state.se = state.ss;

			// return {
			// 	add: '\n' + indent,
			// 	del: selection,
			// 	start: ss
			// };
		}
	},
	
	update: function( newValue, oldValue ) {

	}
});

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});