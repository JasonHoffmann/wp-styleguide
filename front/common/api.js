import Vue from 'Vue';

export default {
  getAll: function() {
      return Vue.http({
        method: 'GET',
        url: styleguide_options.url + '/data',
      });
  },
  
  addSection: function(section) {
    return Vue.http({
      method: 'POST',
      url: styleguide_options.url + '/sections',
      headers: {
        'X-WP-Nonce' : styleguide_options.nonce
      },
      data: {
        title : section.title,
        order: section.order
      }
    });
  },
  
	editSection: function(section, data) {
		return Vue.http({
			method: 'POST',
			url: styleguide_options.url + '/sections/' + section.id,
			headers: {
				'X-WP-Nonce' : styleguide_options.nonce
			},
			data: data
		})
	},
  
  deleteSection: function(id, data) {
    return Vue.http({
      method: 'DELETE',
      url: styleguide_options.url + '/sections/' + id,
      headers: {
        'X-WP-Nonce' : styleguide_options.nonce
      }
    })
  },
	
  addStyle: function(style, section) {
    return Vue.http({
      method: 'POST',
      url: styleguide_options.url + '/styles',
    	headers: {
    		'X-WP-Nonce' : styleguide_options.nonce
    	},
      data: {
        section_id : section.id
      }
    });
  },
  
  editStyle: function(style) {
    return Vue.http({ 
        url: styleguide_options.url + '/styles/' + style.id,
        method: 'POST',
        headers: {
          'X-WP-Nonce' : styleguide_options.nonce
        },
        data: style
      });
  },
  
  deleteStyle: function(id) {
    return Vue.http({ 
    		url: styleguide_options.url + '/styles/' + id,
    		method: 'DELETE',
    		headers: {
    			'X-WP-Nonce' : styleguide_options.nonce
    		},
    		data: { id: id }
    });
  },
	
	updateSettings: function(settings) {
		return Vue.http({
			url: styleguide_options.url + '/settings/',
			method: 'POST',
			headers: {
				'X-WP-Nonce' : styleguide_options.nonce
			},
			data: settings
		})
	}
}