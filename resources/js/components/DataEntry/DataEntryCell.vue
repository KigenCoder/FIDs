<template>
  <td>
    <input v-model="price" v-if="type==='indicator' && column_header_id !== '6'"
           v-on:keyup.enter="savePrice">

    <select
        v-if="type==='indicator' && column_header_id === '6'"
        v-model="supplyId" @change="supplySelected">
      <option value="" disabled selected>Supply</option>
      <option
          v-for="supply in supplyCategories"
          v-bind:value="supply.id">
        {{supply.supply_type}}
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
        supplyId: '',
        price: '',
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
        //console.log("Supply ID: " + this.supplyId);
        this.$store.commit('data_entry/supplyIdMutation', this.supplyId);
        this.$store.dispatch('data_entry/updateSupplyId')

      },
      savePrice: function () {
        this.$store.commit('data_entry/indicatorIdMutation', this.indicator_id)
        this.$store.commit('data_entry/weekIdMutation', this.column_header_id)
        this.$store.commit('data_entry/priceMutation', this.price)
        this.$store.dispatch('data_entry/saveData')
      },
    }
  }
</script>
