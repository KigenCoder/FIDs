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


    refreshPage(state, refresh) {
        state.refresh = refresh
        //console.log(state.refresh)
    },

    marketDataMutation(state, marketData) {
        state.marketData = marketData
    },

    updateMarketDataMutation(state, priceObject) {
        //First check if object exists
        let currentObject

        for (currentObject of state.marketData) {

            if (currentObject.week_id === priceObject.week_id
                && currentObject.month_id === priceObject.month_id
                && currentObject.year_name === priceObject.year_name
                && currentObject.market_id === priceObject.market_id
                && currentObject.indicator_id === priceObject.indicator_id) {

                const index = state.marketData.indexOf(currentObject)
                //Remove existing market data object
                state.marketData.splice(index)
            }
        }

        state.marketData.push(priceObject)
    },

    updateSupplyIdMutation(state, supplyObject) {
        let indicator_id = supplyObject['indicator_id']
        let supply_id = supplyObject['supply_id']
        let currentObject
        for (currentObject of state.marketData) {
            if (currentObject.indicator_id === indicator_id) {
                currentObject.supply_id = supply_id
            }
        }
    },

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
        axios
            .post('./api/save_data', {
                "market_data": JSON.stringify(state.marketData),
            })
            .then(response => {
                commit('utils/loadingStateMutation', false, {root: true})
                alert(response.data)
                console.log(response.data);
            })


    },


}
const getters = {
    getMonthId: state => state.month_id,
    getYearName: state => state.year_name,
    getMarketId: state => state.marketId,
    getMarketTypeId: state => state.marketTypeId,
    getSupplyObject: state => state.supplyObject,
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
}