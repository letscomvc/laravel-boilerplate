import Vue from 'vue';
import Snotify, {SnotifyPosition} from 'vue-snotify';
import {App, plugin as InertiaPlugin} from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

InertiaProgress.init()

Vue.use(InertiaPlugin);
Vue.use(Snotify, {
  toast: {
    timeout: 3000,
    showProgressBar: false,
    position: SnotifyPosition.rightTop
  }
});

Vue.mixin({
  methods: {
    route: (name, params, absolute) => route(name, params, absolute),
  }
});

const app = document.getElementById('app')

new Vue({
  render: h => h(App, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(app)
