require('./bootstrap');
require('./commons');

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

require('./components');
