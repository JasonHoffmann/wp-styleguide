<style lang="sass">

</style>

<script>
var Wrapper = require('./Wrapper.vue');
var Settings = require('./Settings.vue');
var Navbar = require('./Navbar.vue');
var Prism = require('prismjs');
export default {
	
  el: '#app',

  data: {
		all_sections: [],
		showSettings: false,
		settings : {},
		adding: false
  },
	
	components: {
		Wrapper,
		Settings,
		Navbar
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
			
			this.$http({
				method: 'GET',
				url: styleguide_options.url + '/settings'
			}).then(function(response) {
				this.settings = response.data
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
				headers: {
					'X-WP-Nonce' : styleguide_options.nonce
				},
				data: {
					title : newTitle,
					order: len
				}
			}).then(function(response) {
				this.all_sections[nl].id = response.data.id;
			});
			
			
		}

  }
}
</script>