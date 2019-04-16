import Vue from "vue";
import Vuex from "vuex";


Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        zones: []
    },

    mutations: {
        zonesMutation(state, zones) {
            state.zones = zones;
        }
    },

    actions: {
        loadZones({commit}) {
            axios
                .get('./api/zones')
                .then(response => {
                    console.log('Zones called')
                    commit('zonesMutation', response.data)
                })
        }
    },
    getters:{
        getZones: state => state.zones

    },
});
