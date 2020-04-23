import Snotify, {SnotifyPosition} from 'vue-snotify';

window.Vue = require('vue');

Vue.use(Snotify, {
  toast: {
    timeout: 3000,
    showProgressBar: false,
    position: SnotifyPosition.rightTop
  }
});

require('./Components');
