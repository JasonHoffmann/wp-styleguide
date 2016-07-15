<template>
	<div class="sg-st__output">
		{{{ html }}}
	</div>
</template>
<script>
export default {
	props: ['html'],
	
	vuex: {
		getters: {
			root: function(store) {
				return store.root;
			},
			endpoint: function(store) {
				return store.settings.endpoint;
			}
		}
	},
	
	computed: {
			full_url: function() {
				return this.root + this.endpoint + '#';
			}
	},
	
	ready: function() {
		this.processImages();
	},
	
	methods: {
		processImages: function() {
			var images = this.$el.querySelectorAll('img');
			if( images.length > 0 ) {
				var w;
				var h;
				for( var i= 0; i < images.length; i++ ) {
					var src = images[i].src;
					if( src === this.full_url ) {
						w = images[i].getAttribute('width') || 300;
						h = images[i].getAttribute('height') || 300;
						var newimg = 'https://unsplash.it/' + w + '/' + h;
						images[i].src = newimg;
					}
				}
			}
		}.debounce(500)
	},
	
	watch: {
		'html' : function( val, oldval ) {
			if( val !== oldval ) {
				this.processImages();
			}
		}
	}
}
</script>