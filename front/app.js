var Vue = require('vue');
import svg from 'vue-svg-directive'
Vue.use(require('vue-resource'));
var VueEditable= require('./plugins/vue-editable.js');
Vue.use(VueEditable);
Vue.use(svg, {
	sprites: styleguide_options.plugin_url + 'front/app/vendor/icons.svg'
});
var App = require('./components/App.vue')
var Editor = require('./components/Editor.vue');

var app = new Vue(App);

Vue.directive('prism-directive', Editor );

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});