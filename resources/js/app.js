require('./bootstrap');
import Vue from 'vue';

import {store} from "./store/index.js";

Vue.component('zones', require('./components/Zones.vue').default);

var app = new Vue({
    el: '#app',
    store,
    data() {
        return {}
    }
});

