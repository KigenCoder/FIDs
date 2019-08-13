const state = {
  years: [],
  markets: [],
  marketIndicators: [],
  week_id: null,
  month_id: null,
  year_name: null,
  indicator_id: null,
  supply_id: null,
  marketId: null,
  marketTypeId: null,
  price: null,
  refresh: false,
}

const mutations = {
  //Mutate market Type
  marketTypeIdMutation(state, marketTypeId) {
    state.marketTypeId = marketTypeId
  },

  marketsMutation(state, markets) {
    state.markets = markets;
  },

  marketIdMutation(state, marketId) {
    state.marketId = marketId;
  },
  indicatorIdMutation(state, indicator_id) {
    state.indicator_id = indicator_id
  },
  weekIdMutation(state, week_id) {
    state.week_id = week_id
  },
  monthIdMutation(state, month_id) {
    state.month_id = month_id
  },

  yearNameMutation(state, year_name) {
    state.year_name = year_name
  },
  marketIndicatorsMutation(state, marketIndicators) {
    state.marketIndicators = marketIndicators
  },
  priceMutation(state, price) {
    state.price = price
  },

  supplyIdMutation(state, supply_id) {
    state.supply_id = supply_id
  },

  refreshPage(state, refresh){
    state.refresh = refresh
  }

}
const actions = {
  loadMarkets({commit}) {
    axios
      .post('./api/cleaning_markets', {
        market_type_id: state.marketTypeId
      })
      .then(response => {
        commit('marketsMutation', response.data)
      })
  },

  loadMarketIndicators({commit}) {
    axios
      .post('./api/market_indicators', {
        market_type_id: state.marketTypeId,
        month_id: state.month_id,
        year_name: state.year_name,
        market_id: state.marketId,
      })
      .then(response => {
        commit('marketIndicatorsMutation', response.data)
        //console.log(state.marketIndicators);
      })
  },

  saveData() {
    axios
      .post('./api/save_data', {
        year_name: state.year_name,
        month_id: state.month_id,
        week: state.week_id,
        market_id: state.marketId,
        indicator_id: state.indicator_id,
        price: state.price,
        supply_id: state.supply_id,
      })
      .then(response => {
        console.log(response.data);
      })
  },

  updateSupplyId() {
    axios
      .post('./api/supply_update', {
        year_name: state.year_name,
        month_id: state.month_id,
        market_id: state.marketId,
        indicator_id: state.indicator_id,
        supply_id: state.supply_id
      })
      .then(response => {
        console.log(response.data)
      })
  },

}
const getters = {
  getMonthId: state => state.month_id,
  getYearName: state => state.year_name,
  getMarketId: state => state.marketId,
  getMarketTypeId: state => state.marketTypeId,
}

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
}