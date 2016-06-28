import api from './api.js';
export const getAll = function(store) {
  var dispatch = store.dispatch;
  api.getAll().then(function(response) {
    dispatch('RECIEVE_SECTIONS', response.data.sections);
		console.log(response);
    dispatch('RECIEVE_SETTINGS', response.data.settings);
  })
}

export const addSection = function(store, section) {
  var dispatch = store.dispatch;
  dispatch('ADD_SECTION', section);
  api.addSection(section).then(function(response) {
    dispatch('RECIEVE_ID', section, response.data);
  })  
}

export const addStyle = function(store, style, section) {
  var dispatch = store.dispatch;
  dispatch('ADD_STYLE', style, section);
  api.addStyle(style, section).then(function(response) {
    dispatch('RECIEVE_STYLE_ID', section, response.data.id);
  });
}

export const updateStyle = function( store, data, style ) {
  var dispatch = store.dispatch;
  dispatch('EDIT_STYLE', data, style);
  api.editStyle(data);
}

export const removeStyle = function( store, index, section, id ) {
  var dispatch = store.dispatch;
  dispatch('DELETE_STYLE', index, section);
  api.deleteStyle(id);
}

export const toggleActive = function(store, section) {
  var dispatch = store.dispatch;
  dispatch('TOGGLE_ACTIVE', section);
}

export const addSectionPositions = function(store, pos) {
  var dispatch = store.dispatch;
  dispatch('ADD_POSITION', pos);
}

export const toggleSettings = function(store) {
  var dispatch = store.dispatch;
  dispatch('TOGGLE_SETTINGS');
}

export const togglePrivacy = function(store) {
	var dispatch = store.dispatch;
	dispatch('TOGGLE_PRIVACY');
}