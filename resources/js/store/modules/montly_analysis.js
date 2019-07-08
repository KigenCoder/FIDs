const state = {
  zones: [],
  regions: [],
  markets: [],
  indicators: [],
  zone_id: '',
  region_id: '',
  market_id: '',
  indicator_id: '',
  indicator_name: '',
  years: [],
  analysis_data: [],
  start_year: '',
  end_year: '',
  meta_data: {},
  chart_data: [],
  chart_where_clause: '',
  show_chart_data: null,
}

const mutations = {
  //Mutate data
  analysisDataMutation(state, analysis_data) {
    state.analysis_data = analysis_data
  },

  metaDataMutation(state, meta_data) {
    state.meta_data = meta_data
  },
  chartDataMutation(state, chart_data) {
    state.chart_data = chart_data
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

  marketIdMutation(state, market_id) {
    state.market_id = market_id
  },

  //Mutate Indicators
  indicatorsMutation(state, indicators) {
    state.indicators = indicators;
  },

  indicatorIdMutation(state, indicator_id) {
    state.indicator_id = indicator_id

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

  showChartDataMutation(state, show_chart_data) {
    //console.log(show_chart_data)
    state.show_chart_data = show_chart_data
  }


}

const actions = {
  //Fetch Zones
  loadZones({commit}) {
    axios
      .get('./api/zones')
      .then(response => {
        commit('zonesMutation', response.data)
      })
  },

  //Fetch Regions
  loadRegions({commit}) {

    axios
      .post('api/regions', {
        zone_id: state.zone_id

      })
      .then(response => {
        commit('regionsMutation', response.data)
      })
  },

  //Fetch markets
  loadMarkets({commit}) {
    axios
      .post('api/markets', {
        region_id: state.region_id
      })
      .then(response => {
        commit('marketsMutation', response.data)

      })
  },

  loadIndicators({commit}) {
    axios
      .post('api/indicators', {
        market_id: state.market_id
      })
      .then(response => {
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
    axios
      .post('./api/analysis_data', {
        'indicator_id': state.indicator_id,
        'market_id': state.market_id,
        'start_year': state.start_year,
        'end_year': state.end_year,
      })
      .then(response => {
        commit('analysisDataMutation', response.data)
      })
  },

  loadMetaData({commit}) {
    axios
      .post('./api/meta_data', {
        'indicator_id': state.indicator_id,
        'market_id': state.market_id,
        'year': state.end_year,

      })
      .then(response => {
        commit('metaDataMutation', response.data)
      })
  },


}

const getters = {
  getZones: state => state.zones,
  getRegions: state => state.regions,
  getMarkets: state => state.markets,
  getMarketId: state => state.market_id,
  getIndicators: state => state.indicators,
  getIndicatorId: state => state.indicator_id,
  getIndicatorName: state => state.indicator_name,
  getAnalysisData: state => state.analysis_data,
  getChartData: state => state.chart_data,
  getStartYear: state => state.start_year,
  getEndYear: state => state.end_year,
  getMetaData: state => state.meta_data,
  getShowChartData: state => state.show_chart_data,
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}