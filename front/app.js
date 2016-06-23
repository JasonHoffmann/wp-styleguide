import Vue from 'Vue';
Vue.use(require('vue-resource'));
import Editor from './components/Editor.vue';
Vue.directive('prism-directive', Editor );
import App from './components/App.vue';
var app = new Vue(App);

var Input = Vue.extend({
  template: '<input value="{{ value }}" />'
});
