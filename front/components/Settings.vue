<style lang="scss">
#styleguide {
	.sg-settings-title {
		font-size: 36px;
		margin-bottom: 1em;
	}
	.modal-mask {
	  position: fixed;
	  z-index: 9998;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  background-color: #f7f7f7;
	  display: table;
	  transition: opacity .3s ease;
	}

	.modal-wrapper {
	  display: table-cell;
	  vertical-align: top;
		text-align: center;
	}

	.modal-enter, .modal-leave {
	  opacity: 0;
	}
	
	.sg-settings-group {
		margin: 2em auto;
		
		.radio-group {
			display: block;
			position: relative;
			width: 100%;
			float: left;
			height: 100px;
			
			// input[type="radio"] {
			// 	position: absolute;
			// 	visibility: hidden;
			// }
			
			label {
				display: block;
				position: relative;
				padding: 25px 25px 25px 80px;
				margin: 10px auto;
				height: 30px;
				transition: all 0.25s;
				color: #eee;
			}
			
			.check {
				display: block;
				position: absolute;
				border: 5px solid #eee;
				border-radius: 100%;
				height: 25px;
				width: 25px;
				top: 30px;
				left: 20px;
				z-index: 5;
				transition: boder .25s;
				
				&:before {
					display: block;
					position: absolute;
					content: '';
					border-radius: 100%;
					height: 15px;
					width: 15px;
					top: 5px;
					left: 5px;
					margin: auto;
					transition: background 0.25s linear;
				}
			}
		}
	}

	.sg-settings-input-label {
		text-transform: uppercase;
		display: block;
		font-weight: 700;
		margin-bottom: 10px;
		background: transparent;
	}

	.sg-settings-endpoint {
		border: none;
		border-bottom: 1px solid #eee;
		border-radius: 0;
	}

	.sg-settings-endpoint:focus {
		border-bottom-color: #333;
	}
}
</style>

<template>
  <div class="sg-settings modal-mask" v-show="settings.show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container sg-stack">
				<button v-on:click="toggleSettings" class="sg-button sg-button__settings-close">Close</button>
        <h1 class="sg-font-dark sg-settings-title">Settings</h1>
        <!-- <div class="toggleWrapper">
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
        </div> -->
				
				<div class="sg-settings-group">
					<div class="radio-group">
						<input type="radio" id="private" value="private" v-model="privacy">
						<label for="private">Private <br />Only logged in users can view and edit.</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="public" value="public" v-model="privacy">
						<label for="public">Public <br />Anybody can view, logged in users can edit.</label>
					</div>
				</div>
        <div class="sg-settings-group">
          <label class="sg-settings-input-label sg-font-dark">Styleguide URL:</label>
          <span>{{ root }}</span><input class="sg-settings-input sg-settings-endpoint" type="text" v-model="settings.endpoint" />
        </div>
        
        <div class="sg-settings-group">
          <button v-on:click="saveSettings" class="sg-button sg-button-settings-save">Save Settings</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { toggleSettings, togglePrivacy } from '../common/actions.js';
export default {
	vuex: {
		getters: {
			settings: function(state) {
				return state.settings;
			},
			root: function(state) {
				return state.root;
			}
		},
		actions: {
			toggleSettings: toggleSettings,
			togglePrivacy: togglePrivacy
		}
	},
	
	computed: {
		privacy: {
			get: function() {
				console.log(this.settings.private);
				if( this.settings.private === true ) {
					return 'private';
				} else {
					return 'public';
				}
			},
			
			set: function(val) {
				this.togglePrivacy();
			}

		}
	},
  
  methods: {
    saveSettings: function() {
			this.toggleSettings();
      // this.updateSettings({
      //   private: this.private,
      //   endpoint: this.endpoint
      // })
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