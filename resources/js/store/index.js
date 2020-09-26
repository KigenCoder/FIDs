import Vue from "vue";
import Vuex from "vuex";
import monthly_analysis from './modules/montly_analysis'
import data_cleaning from './modules/data_cleaning'
import data_entry from "./modules/data_entry"
import weekly_data from "./modules/weekly_data"
import weekly_data_entry from "./modules/weekly_data_entry";
import utils from "./modules/utils"

Vue.use(Vuex);
//const debug = process.env.NODE_ENV !== 'production'
//export const strict = false
export const store = new Vuex.Store({
        modules: {
            monthly_analysis: monthly_analysis,
            data_cleaning: data_cleaning,
            data_entry: data_entry,
            weekly_data: weekly_data,
            weekly_data_entry: weekly_data_entry,
            utils: utils,
        },
        //strict: debug,
    }
);

