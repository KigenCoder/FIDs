<template>
  <tr v-bind:class="list_item.type">
    <!-- Category/Indicator name -->
    <td>{{list_item.name}}</td>
    <data_cell v-for="header in column_headers"
               v-bind:key="header.id"
               v-bind:indicator_id="list_item.id"
               v-bind:column_header_id="header.id"
               v-bind:type="list_item.type">
    </data_cell>
  </tr>
</template>


<script>
  import data_cell from "./DataEntryCell.vue";

  export default {
    name: 'indicator_list_item',
    props: ['list_item'],
    components: {
      data_cell,
    },

    data() {
      return {
        weekOne: '',
        weekTwo: '',
        weekThree: '',
        weekFour: '',
        weekFive: '',
        supplyId: '',
        column_headers: [],
      }
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
      this.column_headers = [
        {id: "1", "title": "WEEK 1"},
        {id: "2", "title": "WEEK 2"},
        {id: "3", "title": "WEEK 3"},
        {id: "4", "title": "WEEK 4"},
        {id: "5", "title": "WEEK 5"},
        {id: "6", "title": "SUPPLY"},
      ]
    },

    methods: {},
  }
</script>

