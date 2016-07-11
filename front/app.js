import Vue from 'Vue';
Vue.use(require('vue-resource'));
import Global from './components/Global.vue';
import App from './components/App.vue';
var app = new Vue(App);

Vue.filter('comments', function(value, input) {
  if( value ) {
    return value.replace(/<!--[\s\S]*?-->/g, '');
  }
})
