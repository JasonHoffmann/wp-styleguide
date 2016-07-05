<style lang="scss">
#styleguide {
  .sg-onboarding {
    text-align: center;
    
    .sg-style-title {
      line-height: 1.3333;
    }
    button {
      margin-top: 20px;
    }
  }
  
  .sg-onboarding-text {
    margin-top: 10px;
  }
  
  .sg-styles-icon {
    position: relative;
    top: 8px;
    svg {
      height: 32px;
      width: auto;
    }
  }
}
</style>

<template>
<div>
  <section v-if="step === 1">
    <h3 class="sg-style-title">Welcome to <span class="sg-styles-icon"><icon name="styles"></icon></span> <br />An easy way to build <br />Front-end Styleguides</h3>
    <p class="sg-onboarding-text">Let's start by setting a few things up.</p>
    <button v-on:click="incrementStep" class="sg-button sg-button-settings-save">Get Started</button>
  </section>
  
  <section v-if="step === 2">
      <h3 class="sg-settings-input-label">Would you like your styleguide to be private or public?</h3>
      <div class="radio-group">
        <input type="radio" id="private" value="private" v-model="privacy">
        <label for="private"><strong>Private</strong> <br />Only logged in users can view and edit.</label>
        <div class="check"></div>
      </div>
      <div class="radio-group">
        <input type="radio" id="public" value="public" v-model="privacy">
        <label for="public"><strong>Public</strong> <br />Anybody can view, logged in users can edit.</label>
        <div class="check"></div>
      </div>
      
      <button v-on:click="incrementStep" class="sg-button sg-button-settings-save">Next</button>
  </section>
  
  <section v-if="step === 3">
    <label class="sg-settings-input-label sg-font-dark">The URL for your Styleguide:</label>
    <span>{{ root }}</span><input class="sg-settings-input sg-settings-endpoint" type="text" v-model="settings.endpoint" />
    <button v-on:click="saveSettings" class="sg-button sg-button-settings-save">Save Settings and Finish</button>
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