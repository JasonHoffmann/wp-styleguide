<template>
	<svg class="sg-icon" :view-box.camel="box" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
		<title>{{ icon.title }}</title>
		<g>{{{ icon.g }}}</g>
	</svg>
</template>

<script>
import svg from '../common/svg.js';
export default {
	props: {
		name: {
			type: String,
			required: true
		}
	},
	computed: {
		box: function() {
			return `0 0 ${this.icon.width} ${this.icon.height}`
		},
		icon: function() {
			return svg[this.name]
		}
	}
}
</script>