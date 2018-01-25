require('./bootstrap');

window.Vue = require('vue');

import Snotify, { SnotifyPosition } from 'vue-snotify';

const snotify_options = {
  toast: {
    timeout: 3000,
    showProgressBar: false,
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, snotify_options);

Vue.component('data-list', require('./components/DataList.vue'))

const app = new Vue({
    el: '#app',
    props: ['flashMessages'],

    data: {
        handled_flash_messages: false,
    },

    mounted() {
        this.handleFlashMessages();
    },

    methods: {
        throwFlashMessage(type, message) {
            this.$snotify[type](message);
        },

        handleFlashMessages() {
            const flashMessages = document.querySelectorAll('#flash-messages-container > span');
            for (let i = 0; i < flashMessages.length; i++) {
                const flashNode = flashMessages[i];
                const type = flashNode.className;
                const message = flashNode.innerHTML;
                this.throwFlashMessage(type, message);
            }
            // this.handled_flash_messages = true;
        },
    },
});
