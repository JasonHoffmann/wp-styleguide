import Vue from 'Vue';
Vue.use(require('vue-resource'));
import Global from './components/Global.vue';
// import html from './components/Html.vue';
// Vue.directive('html-directive', html);
import App from './components/App.vue';
var app = new Vue(App);

var tagRE = new RegExp(
	"{{" + '(.+?)' + "}}" + '|' +
	"{{" + '(.+?)' + "}}",
	'g'
);
var w = 300;
var h = 500;

var processText = function( text ) {
	var hasFilter = Vue.parsers.directive.parseDirective( text );
	if( hasFilter.filters ) {
		var wh = hasFilter.filters[0].name.split(',');
		w = wh[0] || w;
		h = wh[1] || h;
	}
	
	var img = '<img src="https://unsplash.it/' + w + '/' + h + '">';
	var newval = text.replace( tagRE, img);
	return newval;
};

Vue.filter('comments', function(value, input) {

  if( value ) {
		// TODO: Figure out the right way to do this
    return value.replace(/<!--[\s\S]*?-->/g, '');
  }
})