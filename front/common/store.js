import Vue from 'Vue';

import Vuex from 'vuex'
Vue.use(Vuex);



const state = {
  logged_in: styleguide_options.logged_in,
	root: styleguide_options.home_url,
  sections: [],
  // TODO: Change this to ID instead of full object
  activeSection: {},
  retainedIndex: '',
  sectionPositions: [],
  settings: {},
  loaded: false
}

const mutations = {
	RECIEVE_SECTIONS(state, sections) {
		state.sections = sections;
		state.loaded = true;
	},
	
  ADD_SECTION(state, section) {
    state.sections.push(section);
  },
	
	UPDATE_SECTION(state, title, section) {
		section.title = title;
	},
	
	EDIT_SECTION(state, title, section) {
	},
  
  RECIEVE_ID(state, section, data) {
    section.id = data.id;
  },
	
	TOGGLE_ACTIVE(state, section) {
		state.activeSection = section;
	},
	
	DELETE_SECTION(state, section) {
		state.sections.$remove(section);
	},
	
	RECIEVE_STYLE_ID(state, section, id ) {
		section.styles.$set(state.retainedIndex, {id: id});
		state.retainedIndex = '';
	},
  
  ADD_STYLE(state, style, section) {
    var l = section.styles.push(style);
    l = l - 1;
    state.retainedIndex = l;
    section.styles.$set(l, { editing: true });
  },
  
  EDIT_STYLE(state, data, style) {
    if( data.title ) {
      style.title = data.title;
    }
    
    if( data.html ) {
      style.html = data.html;
    }
  },
  
  DELETE_STYLE(state, index, section) {
    setTimeout( function() {
        section.styles.splice(index, 1);
    }, 10);
  },
	
	ADD_POSITION(state, pos) {
		state.sectionPositions.push(pos);
	},
	
	RECIEVE_SETTINGS(state, settings) {
		settings.show = false;
		state.settings = settings;
	},
	
	TOGGLE_PRIVACY(state, section) {
		state.settings.private = !state.settings.private;
	},
  
  TOGGLE_SETTINGS(state) {
    state.settings.show = !state.settings.show;
  },
	
	UPDATE_SETTINGS(state, newSettings) {
		state.settings = Object.assign({}, state.settings, newSettings);
	}
}

export default new Vuex.Store({
  state,
  mutations
})