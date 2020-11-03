<template>

  <td>
    <input type="number" v-if="type==='indicator' && visible ===true && column_header_id !== '6' "  v-model="price" @blur="updatePriceList">
    <input type="text" v-if="type==='indicator' && visible ===false && column_header_id !== '6' " v-model="price" @focus="onFocusText">

    <select
        v-if="type==='indicator' && column_header_id === '6'"
        v-model="supplyId" @change="supplySelected">
      <option value="" disabled selected>Supply</option>
      <option
          v-for="supply in supplyCategories"
          v-bind:value="supply.id">
        {{ supply.supply_type }}
      </option>
    </select>

  </td>

</template>
<script>

import {mapState} from "vuex";

export default {
  props: [
    'indicator_id',
    'column_header_id',
    'type',
  ],
  name: "data_entry_cell",
  data() {
    return {
      price: '',
      temp: null,
      prices: [],
      visible: true,
      supplyCategories: [],
      supplyId: 4, //Default to normal supply

    }
  },

  computed: {
    ...mapState('weekly_data_entry', []),
    inputType() {
      return this.type === 'indicator' && this.visible
    }
  },


  mounted() {
    this.supplyCategories = [
      {id: 1, supply_type: "Not available"},
      {id: 2, supply_type: "Scarce"},
      {id: 3, supply_type: "Below normal"},
      {id: 4, supply_type: "Normal"},
      {id: 5, supply_type: "Above normal"},
      {id: 6, supply_type: "Surplus"},
    ]

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

      if (marketId && yearName && monthId && weekId && marketPrice !== '' && marketPrice !== null) {
        priceObject = {
          "market_id": marketId,
          "year_name": yearName,
          "month_id": monthId,
          "week_id": weekId,
          "indicator_id": this.indicator_id,
          "price": marketPrice,
          "supply_id" :this.supplyId,
        }
        this.$store.commit('weekly_data_entry/updateMarketDataMutation', priceObject)
      }
    },

    supplySelected: function () {

      if (this.supplyId && this.indicator_id) {
        let supplyObject = {
          "supply_id": this.supplyId,
          "indicator_id": this.indicator_id
        }
        this.$store.commit('weekly_data_entry/updateSupplyIdMutation', supplyObject)

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
