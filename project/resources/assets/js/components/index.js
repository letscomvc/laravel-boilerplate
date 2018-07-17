/* Data list filters */
require('./filters');

/* Data lists */
Vue.component('data-list', require('./DataList.vue'));

/* Breadcrumb */
Vue.component('breadcrumb', require('./Breadcrumb.vue'));
Vue.component('breadcrumb-item', require('./BreadcrumbItem.vue'));

/* Auxiliary */
Vue.component('select-box', require('./SelectBox.vue'));
Vue.component('confirmable', require('./Confirmable.vue'));

/* Main */
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
