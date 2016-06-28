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
  settings: {}
}

const mutations = {
  ADD_SECTION(state, section) {
    state.sections.push(section);
  },
  
  RECIEVE_ID(state, section, data) {
    section.id = data.id;
  },
  
  RECIEVE_STYLE_ID(state, section, id ) {
    section.styles.$set(state.retainedIndex, {id: id});
    state.retainedIndex = '';
  },
  
  RECIEVE_SECTIONS(state, sections) {
    state.sections = sections;
  },
  
  RECIEVE_SETTINGS(state, settings) {
    settings.show = false;
    state.settings = settings;
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
        section.styles.splice(index, 1)
    }, 10);
  },
  
  TOGGLE_ACTIVE(state, section) {
    state.activeSection = section;
  },
	
	TOGGLE_PRIVACY(state, section) {
		state.settings.prviate = !state.settings.private;
	},
  
  ADD_POSITION(state, pos) {
    state.sectionPositions.push(pos);
  },
  
  TOGGLE_SETTINGS(state) {
    state.settings.show = !state.settings.show;
  }
}

export default new Vuex.Store({
  state,
  mutations
})