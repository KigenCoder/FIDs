import Vue from "vue";
import Vuex from "vuex";
import monthly_analysis from './modules/montly_analysis'

Vue.use(Vuex);
//const debug = process.env.NODE_ENV !== 'production'
//export const strict = false
export const store = new Vuex.Store({

    modules: {
      monthly_analysis: monthly_analysis,
    },
    //strict: debug,
  }
);

