<template>
  <td>
    <input v-model="weeklyPrice" v-on:keyup.enter="savePrice">
  </td>
</template>


<script>
  export default {
    name: 'data_cell',
    props: [
      'data_item_id',
      'price',
    ],

    data() {
      return {
        newPrice: ''
      }
    },

    computed: {
      weeklyPrice: {
        get: function () {
          return this.price
        },
        set: function (newWeeklyPrice) {
          this.newPrice = newWeeklyPrice
        }
      }
    },


    methods: {
      savePrice: function () {
        if (!isNaN(parseInt(this.newPrice)) && parseInt(this.newPrice) > 0) {
          this.$store.commit('data_cleaning/priceMutation', this.newPrice);
          this.$store.commit('data_cleaning/priceIdMutation', this.data_item_id)
          this.$store.dispatch('data_cleaning/updateData')
        }
      }
    },
  }
</script>

