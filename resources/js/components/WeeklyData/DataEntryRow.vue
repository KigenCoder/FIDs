<template>
  <tr v-bind:class="list_item.type">
    <!-- Category/Indicator name -->
    <td>{{ list_item.name }}</td>
    <data_cell v-bind:indicator_id="list_item.id" v-bind:type="list_item.type">
    </data_cell>
  </tr>
</template>


<script>
import data_cell from "../WeeklyData/DataEntryCell.vue";

export default {
  name: 'indicator_row',
  props: ['list_item'],
  components: {
    data_cell,
  },

  data() {
    return {}
  },

  computed: {
    currentPrice: {

      get: function () {
        return this.data.price
      },
      set: function (newPrice) {
        /*
          //console.log("New price: " + newValue+ " ID: " + this.data.id)
          let market_data_id = this.data.id;
          if (!isNaN(newPrice) && newPrice > 0) {
            this.$store.commit('data_cleaning/priceMutation', newPrice);
            this.$store.commit('data_cleaning/priceIdMutation', this.data.id)
            this.$store.dispatch('data_cleaning/updateData')
          }
          */


      },


    },

  },

  mounted() {

  },

  methods: {},
}
</script>

