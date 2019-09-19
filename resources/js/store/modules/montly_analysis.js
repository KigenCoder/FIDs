import {consoleError} from "vuetify/lib/util/console";

const state = {
  zones: [],
  regions: [],
  markets: [],
  marketSystemType: '',
  indicators: [],
  zone_id: '',
  region_id: '',
  indicator_id: null,
  indicator_name: '',
  years: [],
  analysis_data: [],
  start_year: '',
  end_year: '',
  meta_data: {},
  chart_data: [],
  tot_chart_data: [],
  chart_where_clause: '',
  show_chart_data: null,
  show_tot_chart_data: null,
  market_ids: null,
  tot_data: [],
  tot_meta_data: [],
  tot_start_year: '',
  tot_end_year: '',
  tot_first_indicator: '',
  tot_second_indicator: '',
  tot_market_ids: null,
  loading: false,
}

const mutations = {
  //Mutate data
  analysisDataMutation(state, analysis_data) {
    state.analysis_data = analysis_data
  },

  metaDataMutation(state, meta_data) {
    state.meta_data = meta_data
  },

  totAnalysisDataMutation(state, tot_data) {
    state.tot_data = tot_data
  },

  totMetaDataMutation(state, tot_meta_data) {
    state.tot_meta_data = tot_meta_data
  },

  chartDataMutation(state, chart_data) {
    state.chart_data = chart_data
  },

  totChartDataMutation(state, tot_chart_data) {
    state.tot_chart_data = tot_chart_data

  },

  //Mutate Zones
  zonesMutation(state, zones) {
    state.zones = zones;
  },

  zoneIdMutation(state, zone_id) {
    state.zone_id = zone_id
  },

  //Mutate regions
  regionsMutation(state, regions) {
    state.regions = regions
  },

  regionIdMutation(state, region_id) {
    state.region_id = region_id
  },

  //Mutate markets
  marketsMutation(state, markets) {
    state.markets = markets
  },

  //Market Ids
  marketIdsMutation(state, market_ids) {
    state.market_ids = market_ids
  },

  totMarketIdsMutation(state, tot_market_ids) {
    state.tot_market_ids = tot_market_ids
  },


  //Mutate Indicators
  indicatorsMutation(state, indicators) {
    state.indicators = indicators;
  },

  indicatorIdMutation(state, indicator_id) {
    state.indicator_id = indicator_id
  },

  totFirstIndicatorMutation(state, tot_first_indicator) {
    state.tot_first_indicator = tot_first_indicator
  },

  totSecondIndicatorMutation(state, tot_second_indicator) {
    state.tot_second_indicator = tot_second_indicator
  },
  indicatorNameMutation(state, indicator_name) {
    state.indicator_name = indicator_name
  },

  yearsMutation(state, years) {
    state.years = years
  },

  startYearMutation(state, start_year) {
    state.start_year = start_year;
  },

  endYearMutation(state, end_year) {
    state.end_year = end_year;
  },

  totStartYearMutation(state, tot_start_year) {
    state.tot_start_year = tot_start_year
  },

  totEndYearMutation(state, tot_end_year) {
    state.tot_end_year = tot_end_year
  },

  showChartDataMutation(state, show_chart_data) {
    //console.log(show_chart_data)
    state.show_chart_data = show_chart_data
  },

  showToTChartDataMutation(state, show_tot_chart_data) {
    state.show_tot_chart_data = show_tot_chart_data
  },

  marketSystemMutation(state, marketSystemType) {
    state.marketSystemType = marketSystemType
  },


}

const actions = {
  //Fetch Zones
  loadZones({commit}) {
    axios
      .get('./api/zones')
      .then(response => {
        commit('zonesMutation', response.data)
        //commit('stopLoading')
      })
  },

  //Fetch Regions
  loadRegions({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('api/regions', {
        zone_id: state.zone_id

      })
      .then(response => {
        commit('regionsMutation', response.data)
        commit('utils/loadingStateMutation', false, {root: true})
      })
  },

  //Fetch markets
  loadMarkets({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('api/markets', {
        region_id: state.region_id,
        system_id: state.marketSystemType,
      })
      .then(response => {
        commit('marketsMutation', response.data)
        commit('utils/loadingStateMutation', false, {root: true})
      })
  },

  loadIndicators({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('api/indicators', {
        system_id: state.marketSystemType
      })
      .then(response => {
        commit('utils/loadingStateMutation', false, {root: true})
        commit('indicatorsMutation', response.data)
      })
  },


  loadYears({commit}) {
    axios
      .get('api/years')
      .then(response => {
        commit('yearsMutation', response.data)
      })
  },

  loadData({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('./api/analysis_data', {
        'indicator_id': state.indicator_id,
        'market_ids': state.market_ids,
        'start_year': state.start_year,
        'end_year': state.end_year,
      })
      .then(response => {
        commit('utils/loadingStateMutation', false, {root: true})
        commit('analysisDataMutation', response.data)
      })
  },

  loadMetaData({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('./api/meta_data', {
        'indicator_id': state.indicator_id,
        'market_ids': state.market_ids,
        'start_year': state.start_year,
        'end_year': state.end_year,
      })
      .then(response => {
        commit('utils/loadingStateMutation', false, {root: true})
        commit('metaDataMutation', response.data)

      })
  },

  loadToTData({commit}) {
    commit('utils/loadingStateMutation', true, {root: true})
    axios
      .post('api/tot_data', {
        'first_indicator': state.tot_first_indicator,
        'second_indicator': state.tot_second_indicator,
        'market_ids': state.tot_market_ids,
        'start_year': state.tot_start_year,
        'end_year': state.tot_end_year
      })
      .then(response => {
        //commit('utils/loadingStateMutation', false, {root: true})
        commit('totAnalysisDataMutation', response.data)
      })

  },

  loadToTMetaData({commit}) {
    //commit('utils/loadingStateMutation', true, {root: true})
    //console.log('I have been called ToT Meta Data')
    axios
      .post('api/tot_meta_data', {
        'first_indicator': state.tot_first_indicator,
        'second_indicator': state.tot_second_indicator,
        'market_ids': state.tot_market_ids,
        'start_year': state.tot_start_year,
        'end_year': state.tot_end_year
      })
      .then(response => {
        commit('utils/loadingStateMutation', false, {root: true})
        //console.log(state.loading)
        commit('totMetaDataMutation', response.data)
      })
  },

}

const getters = {
  getZones: state => state.zones,
  getRegions: state => state.regions,
  getRegionId: state => state.region_id,
  getMarkets: state => state.markets,
  getMarketIds: state => state.market_ids,
  getTotMarketIds: state => state.tot_market_ids,
  getIndicators: state => state.indicators,
  getIndicatorId: state => state.indicator_id,
  getToTFirstIndicator: state => state.tot_first_indicator,
  getToTSecondIndicator: state => state.tot_second_indicator,
  getIndicatorName: state => state.indicator_name,
  getAnalysisData: state => state.analysis_data,
  getToTAnalysisData: state => state.tot_data,
  getChartData: state => state.chart_data,
  getToTChartData: state => state.tot_chart_data,
  getStartYear: state => state.start_year,
  getEndYear: state => state.end_year,
  getToTStartYear: state => state.tot_start_year,
  getToTEndYear: state => state.tot_end_year,
  getMetaData: state => state.meta_data,
  getMarketSystemType: state => state.marketSystemType,
  getShowChartData: state => state.show_chart_data,
  getLoadState: state => state.loadState,
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}