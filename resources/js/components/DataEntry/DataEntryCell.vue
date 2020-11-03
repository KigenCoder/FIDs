<template>
  <td>
    <input type="number" v-if="type==='indicator' && column_header_id !== '6' && visible ===true" v-model="price"
           @blur="savePrice">
    <input type="text" v-if="type==='indicator' && column_header_id !== '6' &&  visible ===false" v-model="price"
           @focus="onFocusText">

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
export default {
  props: [
    'indicator_id',
    'column_header_id',
    'type',
  ],
  name: "data_entry_cell",
  data() {
    return {
      supplyCategories: [],
      supplyId: 4, //Default to normal supply
      price: '',
      visible: true,
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

    supplySelected: function () {

      if(this.supplyId && this.indicator_id){
        let supplyObject = {
          "supply_id" : this.supplyId,
          "indicator_id" : this.indicator_id
        }
        this.$store.commit('data_entry/updateSupplyIdMutation', supplyObject)

      }
    },
    savePrice: function () {
      let year_name = this.$store.getters['data_entry/getYearName']
      let month_id = this.$store.getters['data_entry/getMonthId']
      let week_id = this.column_header_id
      let market_id = this.$store.getters['data_entry/getMarketId']
      let indicator_id = this.indicator_id
      let price = this.price
      //let supply_id = this.supplyId

      let priceObject = {}

      if (market_id && year_name && month_id && week_id && indicator_id
          &&  price !== '' && price !==null) {
        priceObject = {
          "market_id": market_id,
          "year_name": year_name,
          "month_id": month_id,
          "week_id": week_id,
          "indicator_id": indicator_id,
          "price": price,
          "supply_id": this.supplyId,
        }

        this.$store.commit('data_entry/updateMarketDataMutation', priceObject)
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
    },


  }
}
</script>
