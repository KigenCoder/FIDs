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
Vue.component('market_types', require('./components/DataCleaning/MarketType.vue').default);
Vue.component('cleaning_markets', require('./components/DataCleaning/Markets.vue').default);
Vue.component('month_years', require('./components/DataCleaning/MonthYears.vue').default);
Vue.component('data_cleaning_table', require('./components/DataCleaning/DataTable.vue').default);
Vue.component('entry_market_type', require('./components/DataEntry/EntryMarketType.vue').default);
Vue.component('data_entry_markets', require('./components/DataEntry/DataEntryMarkets.vue').default);
Vue.component('entry_month_years', require('./components/DataEntry/EntryMonthYears.vue').default);
Vue.component('data_entry_table', require('./components/DataEntry/DataEntryTable.vue').default);




var app = new Vue({
    el: '#app',
    store,
    data() {
        return {}
    }
});

