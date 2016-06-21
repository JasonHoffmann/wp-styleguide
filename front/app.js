import Vue from 'Vue';
import svg from 'vue-svg-directive';
Vue.use(require('vue-resource'));
Vue.use(svg, {
	sprites: styleguide_options.plugin_url + 'front/app/vendor/icons.svg'
});
import Editor from './components/Editor.vue';
Vue.directive('prism-directive', Editor );
import App from './components/App.vue';
var app = new Vue(App);

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});
