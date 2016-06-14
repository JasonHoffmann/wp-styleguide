var Vue = require('vue');
Vue.use(require('vue-resource'));
var VueEditable= require('./plugins/vue-editable.js');
Vue.use(VueEditable);
var App = require('./components/App.vue')
var Editor = require('./components/Editor.vue');

var app = new Vue(App);

Vue.directive('prism-directive', Editor );

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});