const state = {
  years: [],
  markets: [],
  market_data: [],
  month_id: null,
  year_name: null,
  marketId: null,
  marketTypeId: null,
  priceId: null,
  updatedPrice: null,
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
  monthIdMutation(state, month_id) {
    state.month_id = month_id
  },

  yearNameMutation(state, year_name) {
    state.year_name = year_name
  },
  marketDataMutation(state, market_data) {
    state.market_data = market_data
  },

  priceIdMutation(state, priceId) {
    state.priceId = priceId
  },

  priceMutation(state, updatedPrice) {
    state.updatedPrice = updatedPrice
  },

  refreshPage(state, refresh){
    state.refresh = refresh
  },

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

  loadMarketData({commit}) {
    axios
      .post('./api/cleaning_data', {
        market_type_id: state.marketTypeId,
        month_id: state.month_id,
        year_name: state.year_name,
        market_id: state.marketId,
      })
      .then(response => {
        commit('marketDataMutation', response.data)
      })
  },


  updateData() {
    axios
      .post('./api/update_data', {
        price_id: state.priceId,
        price: state.updatedPrice,
      })
      .then(response=>{
        console.log(response.data);
        //alert(response.data['message'])
      })
  }

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