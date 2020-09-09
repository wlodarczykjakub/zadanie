/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import { BPagination } from 'bootstrap-vue'
import { BTable } from 'bootstrap-vue'
import { BModal } from 'bootstrap-vue'
import { VBModal } from 'bootstrap-vue'
import { BButton } from 'bootstrap-vue'

import moment from 'moment'

Vue.component('b-pagination', BPagination);
Vue.component('b-table', BTable);
Vue.component('b-modal', BModal)
Vue.component('b-button', BButton)
Vue.directive('b-modal', VBModal)


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('invoice-component', require('./components/InvoiceComponent.vue').default);


Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm');
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
