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
    loadState: 0,
    marketUpdates: [],
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


    refreshPage(state, refresh) {
        state.refresh = refresh
        //console.log(state.refresh)
    },

    marketUpdatesMutation(state, priceObject) {
        //First check if object exists
        let marketUpdateObject

        for (marketUpdateObject of state.marketUpdates) {

            if (marketUpdateObject.price_id === priceObject.price_id) {

                const index = state.marketUpdates.indexOf(marketUpdateObject)
                //Remove existing market data object
                state.marketUpdates.splice(index, 1)
            }
        }

        state.marketUpdates.push(priceObject)
    }

}
const actions = {
    loadMarkets({commit}) {
        commit('utils/loadingStateMutation', true, {root: true})
        axios
            .post('./api/cleaning_markets', {
                market_type_id: state.marketTypeId
            })
            .then(response => {
                commit('utils/loadingStateMutation', false, {root: true})
                commit('marketsMutation', response.data)
            })
    },

    loadMarketData({commit}) {
        commit('utils/loadingStateMutation', true, {root: true})
        axios
            .post('./api/cleaning_data', {
                market_type_id: state.marketTypeId,
                month_id: state.month_id,
                year_name: state.year_name,
                market_id: state.marketId,
            })
            .then(response => {
                commit('utils/loadingStateMutation', false, {root: true})
                commit('marketDataMutation', response.data)
                //console.log(state.market_data)
            })
    },


    updateData({commit}) {

        commit('utils/loadingStateMutation', true, {root: true})
        axios
            .post('./api/update_data', {
                "market_data": JSON.stringify(state.marketUpdates),
            })
            .then(response => {
                commit('utils/loadingStateMutation', false, {root: true})
                //console.log(response.data);
                alert(response.data)
            })

        /*
          let priceObject
          for(priceObject of state.marketUpdates){
              console.log("ID: " + priceObject.price_id + "Price: " + priceObject.price)
          }

         */
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