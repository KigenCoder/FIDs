const state = {
    years: [],
    markets: [],
    marketIndicators: [],
    week_id: null,
    month_id: null,
    year_name: null,
    indicator_id: null,
    marketId: null,
    marketTypeId: null,
    price: null,
    refresh: false,
    marketData: [],
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


    refreshPageMutation(state, refresh) {
        state.refresh = refresh
        //console.log(state.refresh)
    },
    marketDataMutation(state, marketData) {
        state.marketData = marketData
    },


    updateMarketDataMutation(state, priceObject) {
        //console.log(priceObject.indicator_id, priceObject.price)
        state.marketData.push(priceObject)

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

    loadMarketIndicators({commit}) {
        commit('utils/loadingStateMutation', true, {root: true})
        axios
            .post('./api/market_indicators', {
                market_type_id: state.marketTypeId,
                month_id: state.month_id,
                year_name: state.year_name,
                market_id: state.marketId,
            })
            .then(response => {
                commit('utils/loadingStateMutation', false, {root: true})
                commit('marketIndicatorsMutation', response.data)
                //console.log(state.marketIndicators);
            })
    },



    saveData({commit}) {
        commit('utils/loadingStateMutation', true, {root: true})

        if (state.marketData.length > 0) {
            try {

                axios
                    .post('./api/save_weekly', {
                        "market_data": JSON.stringify(state.marketData),
                    })
                    .then(response => {
                        commit('utils/loadingStateMutation', false, {root: true})
                        alert("Saved: " + response.data.saved + " Existing:  " + response.data.existing)
                        //console.log(response.data);
                    })


            } catch (exception) {
                console.log(exception.toLocaleString())
            }

        }


    },


}
const getters = {
    getWeekId: state => state.week_id,
    getMonthId: state => state.month_id,
    getYearName: state => state.year_name,
    getMarketId: state => state.marketId,
    getMarketTypeId: state => state.marketTypeId,
    getMarketData: state => state.marketData
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
}