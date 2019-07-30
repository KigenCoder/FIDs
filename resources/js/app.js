require('./bootstrap');
import Vue from 'vue';
import {store} from "./store/index.js"
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
Vue.component('zones', require('./components/analysis/Zones.vue').default);
Vue.component('regions', require('./components/analysis/Regions.vue').default);
Vue.component('market_type', require('./components/analysis/MarketType.vue').default);
Vue.component('markets', require('./components/analysis/Markets.vue').default);
Vue.component('indicators', require('./components/analysis/Indicators.vue').default);
Vue.component('time_period', require('./components/analysis/TimePeriod.vue').default);
Vue.component('average', require('./components/analysis/AveragePeriod.vue').default);
Vue.component('series', require('./components/analysis/TimeSeries.vue').default);
Vue.component('market_data', require('./components/analysis/MarketData.vue').default);
Vue.component('modal',require('./components/analysis/TimeSeriesChart.vue').default);
Vue.component('first_indicator', require('./components/ToT/FirstIndicator.vue').default);
Vue.component('second_indicator', require('./components/ToT/SecondIndicator.vue').default);
Vue.component('tot_markets', require('./components/ToT/ToTMarkets.vue').default);
Vue.component('tot_time_period', require('./components/ToT/ToTTimePeriod.vue').default);
Vue.component('tot_time_series', require('./components/ToT/ToTTimeSeries.vue').default);
Vue.component('tot_data', require('./components/ToT/ToTData.vue').default);
Vue.component('tot_series_chart', require('./components/ToT/TOTTimeSeriesChart.vue').default);


var app = new Vue({
    el: '#app',
    store,
    data() {
        return {}
    }
});

