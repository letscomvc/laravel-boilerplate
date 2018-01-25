import Snotify, { SnotifyPosition } from 'vue-snotify';
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
require('vue-flash-message/dist/vue-flash-message.min.css');

window.Vue = require('vue');


const snotify_options = {
  toast: {
    timeout: 3000,
    showProgressBar: false,
    position: SnotifyPosition.rightTop
  }
}

Vue.use(Snotify, snotify_options);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

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
            this.handled_flash_messages = true;
        },
    },
});
