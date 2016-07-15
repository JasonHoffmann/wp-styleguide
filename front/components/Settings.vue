<style lang="scss">
#styleguide {
	.sg-set__title {
		font-size: 36px;
		margin-bottom: 10px;
		margin-top: 40px;
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
	
	.sg-set__close {
		position: absolute;
		top: 1em;
		right: 2em;
		box-shadow: none;
		svg {
			width: 25px;
			height: auto;
			
		}
	}
	
	.sg-set__group {
		margin: 40px 0;
	}
	
	.sg-set__label {
		display: block;
		text-align: center;
		width: 100%;
		font-weight: bold;
		font-size: 20px;
		margin-bottom: 10px;
	}
	
	.sg-set__radio-group {
		margin: 0 auto;
		max-width: 350px;
		display: block;
		position: relative;
		width: 100%;
		height: 100px;
		text-align: left;
		cursor: pointer;
		
		input[type="radio"] {
			position: absolute;
			visibility: hidden;
		}
		
		label {
			display: block;
			position: relative;
			padding: 25px 25px 25px 80px;
			margin: 10px auto;
			height: 30px;
			transition: all 0.25s;
			color: #666;
			cursor: pointer;
		}
		
		.check {
			display: block;
			position: absolute;
			border: 5px solid #666;
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
		
		input[type=radio]:checked ~ .check {
			border: 5px solid #333;
		}

		input[type=radio]:checked ~ .check::before{
			background: #333;
		}

		input[type=radio]:checked ~ label{
			color: #333;
		}
	}

	.sg-set__endpoint {
		border: none;
		border-bottom: 1px dotted #666;
		background: transparent !important;
		border-radius: 0;
		position: relative;
		top: -1px;
	}

	.sg-set__endpoint:focus {
		border-bottom-color: #333;
	}
	

}
</style>

<template>
  <div class="sg-settings modal-mask" v-show="settings.show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container sg-stack">
				<button v-on:click="toggleSettings" class="sg-button sg-set__close"><icon name="cancel"></icon></button>
        <h1 class="sg-font-dark sg-set__title">{{ styleguide_options.str_settings }}</h1>
				
				<div class="sg-set__group">
					<h3 class="sg-set__label">Privacy:</h3>
					<div class="sg-set__radio-group">
						<input type="radio" id="private" value="private" v-model="privacy">
						<label for="private">Private <br />Only logged in users can view and edit.</label>
						<div class="check"></div>
					</div>
					<div class="sg-set__radio-group">
						<input type="radio" id="public" value="public" v-model="privacy">
						<label for="public">Public <br />Anybody can view, logged in users can edit.</label>
						<div class="check"></div>
					</div>
				</div>
        <div class="sg-set__group">
          <label class="sg-set__label">Styleguide URL:</label>
          <span>{{ root }}</span><input class="sg-set__endpoint" type="text" v-model="settings.endpoint" />
        </div>
        
        <div class="sg-st__group">
          <button v-on:click="saveSettings" class="sg-button sg-set__save">Save Settings</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import actions from '../common/actions.js';
import Icon from './Icon.vue';
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
			toggleSettings: actions.toggleSettings,
			togglePrivacy: actions.togglePrivacy,
			updateSettings: actions.updateSettings
		}
	},
	
	components: {
		Icon
	},
	
	computed: {
		privacy: {
			get: function() {
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
			this.updateSettings({
				endpoint: this.settings.endpoint,
				private: this.settings.private
			});
    }
  }
}
</script>