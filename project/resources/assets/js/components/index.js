/* Data list filters */
require('./filters');

/* Data lists */
Vue.component('data-list', require('./DataList.vue').default);

/* Breadcrumb */
Vue.component('breadcrumb', require('./Breadcrumb.vue').default);
Vue.component('breadcrumb-item', require('./BreadcrumbItem.vue').default);

/* Auxiliary */
Vue.component('select-box', require('./SelectBox.vue').default);
Vue.component('confirmable', require('./Confirmable.vue').default);

/* Main */
const app = new Vue(require('./App.vue').default);
