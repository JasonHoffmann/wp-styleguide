import api from './api.js';

export default {
	getAll: function(store) {
	  var dispatch = store.dispatch;
	  api.getAll().then(function(response) {
	    dispatch('RECIEVE_SECTIONS', response.data.sections);
	    dispatch('RECIEVE_SETTINGS', response.data.settings);
	  })
	},
	
	addSection: function(store, section) {
	  var dispatch = store.dispatch;
	  dispatch('ADD_SECTION', section);
		
		var self = this;
	  api.addSection(section).then(function(response) {
				dispatch('RECIEVE_ID', section, response.data);
				var newStyle = {
					title: '',
					html: '<!-- insert your code here -->',
					id: 0
				};
				dispatch('ADD_STYLE', newStyle, section);
	  })  
	},
	
	updateSection: function(store, title, section) {
		var dispatch = store.dispatch;
		dispatch('UPDATE_SECTION', title, section);
	},
	
	editSection: function(store, title, section) {
		var dispatch = store.dispatch;
		dispatch('UPDATE_SECTION', title, section);
		api.editSection(section, {title: title});
	},
	
	deleteSection: function(store, section) {
		var dispatch = store.dispatch;
		dispatch('DELETE_SECTION', section);
		api.deleteSection(section.id);
	},
	
	addStyle: function(store, style, section) {
	  var dispatch = store.dispatch;
	  dispatch('ADD_STYLE', style, section);
	},
	
	saveNewStyle: function(store, style, section) {
		var dispatch = store.dispatch;
		api.addStyle(style, section).then(function(response) {
			dispatch('RECIEVE_STYLE_ID', style, response.data.id);
		})
	},
	
	updateHtml: function(store, data, style) {
		var dispatch = store.dispatch;
		dispatch('UPDATE_HTML', data, style);
	},
	
	updateStyle: function( store, data, style ) {
	  var dispatch = store.dispatch;
	  dispatch('EDIT_STYLE', data, style);
	  api.editStyle(data);
	},
	
	removeStyle: function( store, index, section, id ) {
	  var dispatch = store.dispatch;
	  dispatch('DELETE_STYLE', index, section);
	  api.deleteStyle(id);
	},
	
	toggleActive: function(store, section) {
	  var dispatch = store.dispatch;
	  dispatch('TOGGLE_ACTIVE', section);
	},
	
	addSectionPositions: function(store, pos) {
	  var dispatch = store.dispatch;
	  dispatch('ADD_POSITION', pos);
	},
	
	toggleSettings: function(store) {
	  var dispatch = store.dispatch;
	  dispatch('TOGGLE_SETTINGS');
	},
	
	togglePrivacy: function(store) {
		var dispatch = store.dispatch;
		dispatch('TOGGLE_PRIVACY');
	},
	
	updateSettings: function(store, newSettings) {
		var dispatch = store.dispatch;
		dispatch('UPDATE_SETTINGS', newSettings);
		api.updateSettings(newSettings).then(function(response) {
			if( response.data.redirect ) {
			  window.location = styleguide_options.home_url + '/' + newSettings.endpoint;
			}
		})
	}

}