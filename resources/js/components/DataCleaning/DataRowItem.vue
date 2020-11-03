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
    <td>{{ data_row.lastMonthAverage }}</td>
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
      maxWeeksPerMonth: 5
    }
  },

  computed: {},

  methods: {}
}
</script>

