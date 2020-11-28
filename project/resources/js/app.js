import Vue from 'vue';
import Snotify, {SnotifyPosition} from 'vue-snotify';
import {App as InertiaApp, plugin as InertiaPlugin} from '@inertiajs/inertia-vue'
import {InertiaProgress} from '@inertiajs/progress';
import Dayjs from 'dayjs';

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

Vue.prototype.$route = (name, params, absolute) => route(name, params, absolute);
Vue.prototype.$dayjs = (...params) => Dayjs(...params);

const appElement = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(appElement.dataset.page),
      resolveComponent: name => require(`./Pages/${name}`).default,
    },
  }),
}).$mount(appElement)
