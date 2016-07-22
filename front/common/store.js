import Vue from 'Vue';

import Vuex from 'vuex'
Vue.use(Vuex);



const state = {
  logged_in: styleguide_options.logged_in,
	root: styleguide_options.home_url,
  sections: [],
  // TODO: Change this to ID instead of full object
  activeSection: '',
  retainedIndex: '',
  sectionPositions: [],
  settings: {},
  loaded: false
}

const mutations = {
	RECIEVE_SECTIONS(state, sections) {
		for( var i = 0, len = sections.length; i < len; i++ ) {
			sections[i].selected = false;
		}
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
		
		for( var i = 0, len = state.sections.length; i < len; i++) {
			if( state.sections[i].id !== section.id ) {
				state.sections[i].selected = false;
			}
		}
		state.activeSection = section.id;
		section.selected = true;
	},
	
	DELETE_SECTION(state, section) {
		state.sections.$remove(section);
	},
	
	RECIEVE_STYLE_ID(state, style, id ) {
    style.id = id;
	},
  
  ADD_STYLE(state, style, section) {
    section.styles.push(style);
  },
  
  EDIT_STYLE(state, data, style) {
    if( data.title ) {
      style.title = data.title;
    }
    
    if( data.html ) {
      style.html = data.html;
    }
  },
  
  UPDATE_HTML(state, data, style, ss, se) {
    style.html = data;
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
  mutations,
  // TODO: Get this working in strict mode - v-model
  // strict: true
})