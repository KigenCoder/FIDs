<template>
  <tr v-bind:class="data_row.type">
    <td>{{ data_row.name }}</td>
    <td v-for="currentIndex in this.maxWeeksPerMonth" :key="currentIndex">
      <data_cell
          v-bind:currentIndex="currentIndex"
          v-bind:type="data_row.type"
          v-bind:dataSet="data_row.dataSet">

      </data_cell>
    </td>
    <td>{{ thousandSeparator(data_row.lastMonthAverage) }}</td>
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
      maxWeeksPerMonth: 5,
    }
  },

  computed: {

    blankCells: {
      get: function () {
        let totalCells = 5
        return totalCells - this.data_row.dataSet.length
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
      {id: "6", "title": "AVERAGE"},
    ]
  },

  methods: {
    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      } else {
        return amount;
      }
    }
  },
}
</script>

