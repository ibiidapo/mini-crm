/**
 * Bootstrap all libraries
 */
/**
 * Register routes-pages to vue js
 */

require('./bootstrap');

/**
 *  Load and setup Vue JS and libraries
 */
require('./libraries');
require('./prototypes');
/**
 * Create some global vue js mixins
 */
require('./mixins');

/**
 * Register components
 */
window.Vue.component('app-footer', require('./components/AppFooter.vue'));
window.Vue.component('app-header', require('./components/AppHeader.vue'));
// window.Vue.component('pagination', require('./components/PaginationComponent.vue'));
window.Vue.component('clients-index', require('./views/ClientsIndex.vue'));
window.Vue.component('client-form', require('./components/ClientForm.vue'));
window.Vue.component('transactions-index', require('./views/TransactionsIndex.vue'));
window.Vue.component('transactions-edit', require('./views/TransactionsEdit.vue'));

const EventBus = new Vue();

window.app = new window.Vue({
  el: '#app',
  data: function() {
    return {
      user: window.user,
    };
  }, // router,
  // render: h => h(App),
});
