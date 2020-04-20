<template>
  <tr v-bind:class="data_row.type">
    <td>{{data_row.name}}</td>
    <data_cell
        v-for="(data_item, index) in data_row.dataSet"
        v-bind:data_item_id="data_item.id"
        v-bind:price="data_item.price"
        v-bind:key="index">
    </data_cell>
    <td v-for="blank in blankCells"></td>
    <td>{{data_row.lastMonthAverage}}</td>

  </tr>
</template>


<script>
  import data_cell from "./DataCell.vue";

  export default {
    name: 'data_row_item',
    props: ['data_row'],
    components: {
      data_cell,
    },

    data() {
      return {
        column_headers: [],

      }
    },

    computed: {

      blankCells: {
        get: function () {
          let totalCells = 5
          let blanks = totalCells - this.data_row.dataSet.length
          return blanks
        },
      }
    },

    mounted() {
      this.column_headers = [
        {id: "1", "title": "WEEK 1"},
        {id: "2", "title": "WEEK 2"},
        {id: "3", "title": "WEEK 3"},
        {id: "4", "title": "WEEK 4"},
        {id: "5", "title": "WEEK 5"},
        {id: "6", "title": "PREVIOUS MONTH AVERAGE"},
      ]
    },

    methods: {}
  }
</script>

