<style lang="scss">
	.sg-settings {
		display: none;
	}
</style>
<template>
  <div class="sg-settings modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container sg-stack">
        <h1 class="sg-font-dark">Settings</h1>
        <div class="toggleWrapper">
          <div class="after">
            <span class="sg-setting-title sg-font-light">Public</span>
            <span class="small sg-font-dark">(Anybody can view)</span>
          </div>
          <input type="checkbox" class="checkbox" id="dn" v-model="private"/>
            <label for="dn" class="toggle"> 
              <span class="toggle__handler"></span>
            </label>
          <div class="after">
            <span class="sg-setting-title sg-font-light">Private</span>
            <span class="small">(Logged in users can view)</span>
          </div>
        </div>
        <div class="sg-settings-group">
          <label class="sg-settings-input-label sg-font-dark">Styleguide URL:</label>
          <span>{{ home_url }}</span><input class="sg-settings-input sg-settings-endpoint" type="text" v-model="endpoint" />
        </div>
        
        <div class="sg-settings-group">
          <button v-on:click="saveSettings" class="sg-button sg-button-settings-save">Save Settings</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true,
      twoWay: true
    },
    private: Boolean,
    endpoint: String,
    home_url: {
      type: String,
      default: styleguide_options.home_url
    }
  },
  
  methods: {
    togglePrivate: function() {
      this.private = !this.private;
      this.updateSettings({
        private: this.private
      })
    },
    
    saveSettings: function() {
      this.updateSettings({
        private: this.private,
        endpoint: this.endpoint
      })
    },
    
    updateSettings: function(obj) {
      this.$http({ 
          url: styleguide_options.url + '/settings/',
          method: 'POST',
					headers: {
						'X-WP-Nonce' : styleguide_options.nonce
					},
          data: obj
        }).then(function(response) {
          if( response.data.redirect ) {
            window.location = styleguide_options.home_url + '/' + this.endpoint;
          }
        });
    }
  }
}
</script>