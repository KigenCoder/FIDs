<template>

  <td>
    <input type="number" v-if="type==='indicator'" v-model="price" v-on:blur="updatePriceList">
  </td>

</template>


<script>

import {mapState} from "vuex";

export default {
  props: [
    'indicator_id',
    'type',
  ],
  name: "data_entry_cell",
  data() {
    return {
      price: '',
      prices: [],

    }
  },

  computed: {
    ...mapState('monthly_analysis', [])
  },


  mounted() {

  },
  methods: {

    updatePriceList: function () {
      let marketId = this.$store.getters['weekly_data_entry/getMarketId']
      let monthId = this.$store.getters['weekly_data_entry/getMonthId']
      let weekId = this.$store.getters["weekly_data_entry/getWeekId"]
      let yearName = this.$store.getters['weekly_data_entry/getYearName']

      //console.log("Week ID: " + weekId)

      let priceObject = {}
      if (marketId && yearName && monthId && weekId) {
        priceObject = {
          "market_id": marketId,
          "year_name": yearName,
          "month_id": monthId,
          "week_id": weekId,
          "indicator_id": this.indicator_id,
          "price": this.price,
        }
        let numeralPrice = +this.price

        //console.log("Not a number: " + this.price)

        if (Number.isInteger(numeralPrice)) {
          this.$store.commit('weekly_data_entry/updateMarketDataMutation', priceObject)
        }

      }


    },
  }
}
</script>
