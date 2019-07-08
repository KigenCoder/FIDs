require('./bootstrap');
import Vue from 'vue';
import vSelect from 'vue-select'
import {store} from "./store/index.js"





Vue.component('v-select', vSelect)
Vue.component('zones', require('./components/analysis/Zones.vue').default);
Vue.component('regions', require('./components/analysis/Regions.vue').default);
Vue.component('markets', require('./components/analysis/Markets.vue').default);
Vue.component('indicators', require('./components/analysis/Indicators.vue').default);
Vue.component('time_period', require('./components/analysis/TimePeriod.vue').default);
Vue.component('average', require('./components/analysis/AveragePeriod.vue').default);
Vue.component('series', require('./components/analysis/TimeSeries.vue').default);
Vue.component('market_data', require('./components/analysis/MarketData.vue').default);
Vue.component('modal',require('./components/analysis/TimeSeriesChart.vue').default);

var app = new Vue({
    el: '#app',
    store,
    data() {
        return {}
    }
});

