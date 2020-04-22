import Vue from 'vue';
import Snotify, { SnotifyPosition } from 'vue-snotify';
import { InertiaApp } from '@inertiajs/inertia-vue'

require('./bootstrap');
require('./support');

const snotifyOptions = {
  toast: {
    timeout: 3000,
    showProgressBar: false,
    position: SnotifyPosition.rightTop
  }
};

Vue.use(InertiaApp);
Vue.use(Snotify, snotifyOptions);

const app = document.getElementById('app')
new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)