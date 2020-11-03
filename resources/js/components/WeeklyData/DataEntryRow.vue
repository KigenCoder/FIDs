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
import data_cell from "../WeeklyData/DataEntryCell.vue";

export default {
  name: 'indicator_row',
  props: ['list_item'],
  components: {
    data_cell,
  },

  data() {
    return {
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

      },


    },

  },

  mounted() {
    this.column_headers = [
      {id: "1", "title": "Week Data"},
      {id: "6", "title": "SUPPLY"},
    ]
  },

  methods: {},
}
</script>

