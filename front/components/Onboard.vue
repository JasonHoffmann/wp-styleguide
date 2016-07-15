<style lang="scss">
#styleguide {
  .sg-onboarding {
    text-align: center;
		max-width: 600px;
		width: 80%;
		margin: 0 auto;
  }
	
	.sg-ob__title {
		font-size: 36px;
		margin: 0.5em 0;
	}
	
	.sg-ob__subtitle {
		font-size: 24px;
		margin: 0.5em 0 2em 0;
		font-weight: 200;
		color: $gray-lighter;
		letter-spacing: 1px;
		text-transform: uppercase;
	}
	
	.sg-ob__subtitle.m-main {
		margin: 1em 0 1em 0;
	}
  
  .sg-ob__icon {
    position: relative;
    top: 10px;
    svg {
      height: 45px;
      width: auto;
    }
  }
	
	.sg-ob__button {
		border: 1px solid $gray-light;
		padding: 10px;
		margin: 1em 0;
		&:hover {
			background: $gray-light;
			color: $white !important;
		}
		&.m-right {
			float: right;
		}
		&.m-left {
			float: left;
		}
	}
	
	.sg-ob__text.m-push {
		margin-bottom: 2em;
	}
}
</style>

<template>
<div class="sg-onboarding sg-stack">
  <section v-if="step === 1">
    <h3 class="sg-ob__title">Welcome to <span class="sg-ob__icon"><icon name="styles"></icon></span></h3>
		<h4 class="sg-ob__subtitle">An easy way to build Front-end Styleguides</h4>
    <p class="sg-ob__text">Let's start by setting a few things up.</p>
    <button v-on:click="incrementStep" class="sg-button sg-ob__button">Get Started</button>
  </section>
  
  <section v-if="step === 2">
      <h3 class="sg-ob__subtitle m-main">Would you like your styleguide to be private or public?</h3>
      <div class="sg-set__radio-group">
        <input type="radio" id="private" value="private" v-model="privacy">
        <label for="private"><strong>Private</strong> <br />Only logged in users can view and edit.</label>
        <div class="check"></div>
      </div>
      <div class="sg-set__radio-group">
        <input type="radio" id="public" value="public" v-model="privacy">
        <label for="public"><strong>Public</strong> <br />Anybody can view, logged in users can edit.</label>
        <div class="check"></div>
      </div>
      <div class="sg-row">
      	<button v-on:click="incrementStep" class="sg-button sg-ob__button m-right">Next</button>
			</div>
  </section>
  
  <section v-if="step === 3">
    <h3 class="sg-ob__subtitle m-main">The URL for your Styleguide:</h3>
    <p class="sg-ob__text m-push">
			<span>{{ root }}</span><input class="sg-set__endpoint" type="text" v-model="settings.endpoint" />
		</p>
		<div class="sg-row">
			<button v-on:click="decrementStep" class="sg-button sg-ob__button m-left">Previous</button>
	    <button v-on:click="saveSettings" class="sg-button sg-ob__button m-right">Save Settings and Finish</button>
		</div>
  </section>
</div>
</template>
<script>
import Icon from './Icon.vue';
import actions from '../common/actions.js';
export default {
  data: function() {
      return {
        step: 1
      }
  },
  
  vuex: {
    getters: {
      settings: function(state) {
        return state.settings;
      },
      root: function(state) {
        return state.root
      }
    },
    actions: {
      toggleSettings: actions.toggleSettings,
      togglePrivacy: actions.togglePrivacy,
      updateSettings: actions.updateSettings
    }
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
  
  components: {
    Icon
  },
  
  methods: {
    incrementStep: function() {
      this.step = this.step + 1;
    },
		decrementStep: function() {
			this.step = this.step - 1;
		},
    saveSettings: function() {
      this.updateSettings({
        endpoint: this.settings.endpoint,
        private: this.settings.private,
        onboarded: true
      });
    }
  }
}
</script>