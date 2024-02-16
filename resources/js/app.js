/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import vSelect from 'vue-select';

import UsersTable from './components/Users/UsersTable.vue'
import ProductTable from './components/Products/ProductTable.vue'
import ProductDetail from './components/Products/ProductDetail.vue'
import CategoryTable from './components/Categories/CategoryTable.vue'
import BackendError from './components/Components/BackendError.vue'
import Cart from './components/Cart/Cart.vue'


const app = createApp({
    components: {
        UsersTable,
        ProductTable,
        CategoryTable,
        ProductDetail,
        Cart
    }
});


app.component('v-select', vSelect)
app.component('backend-error', BackendError)
app.mount('#app');
