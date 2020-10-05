<template>

  <td>
    <input type="number" v-if="type==='indicator' && visible ===true" v-model="price" @blur="updatePriceList">
    <input type="text" v-if="type==='indicator' && visible ===false" v-model="price" @focus="onFocusText">
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
      temp: null,
      prices: [],
      visible: true,

    }
  },

  computed: {
    ...mapState('monthly_analysis', []),
    inputType() {
      return this.type === 'indicator' && this.visible
    }
  },


  mounted() {

  },
  methods: {

    updatePriceList: function () {

      /* For displaying 1000 separator */
      this.visible = false
      this.temp = this.price
      this.price = this.thousandSeparator(this.price)

      let marketId = this.$store.getters['weekly_data_entry/getMarketId']
      let monthId = this.$store.getters['weekly_data_entry/getMonthId']
      let weekId = this.$store.getters["weekly_data_entry/getWeekId"]
      let yearName = this.$store.getters['weekly_data_entry/getYearName']

      let priceObject = {}

      //Check if price is empty
      const marketPrice = this.temp

      //console.log("Market price: " + marketPrice)

      if (marketId && yearName && monthId && weekId && marketPrice !== '' && marketPrice !==null) {
        priceObject = {
          "market_id": marketId,
          "year_name": yearName,
          "month_id": monthId,
          "week_id": weekId,
          "indicator_id": this.indicator_id,
          "price": marketPrice,
        }

        this.$store.commit('weekly_data_entry/updateMarketDataMutation', priceObject)


      }

    },

    onFocusText() {
      this.visible = true;
      this.price = this.temp;
    },

    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      } else {
        return amount;
      }
    }

  }
}
</script>
