<template>
  <div class="container">
    <table class="table is-bordered is-narrow is-hoverable is-fullwidth is-size-7">
      <th>INDICATOR</th>
      <th>WEEK 1</th>
      <th>WEEK 2</th>
      <th>WEEK 3</th>
      <th>WEEK 4</th>
      <th>WEEK 5</th>
      <th>Last month's average</th>
      <tbody>
      <data_row_item v-for="(data_row, index) in market_data"
          v-bind:data_row="data_row"
          v-bind:key="index">
      </data_row_item>
      </tbody>
    </table>
  </div>


</template>

<script>
  import {mapState} from 'vuex';
  import data_row_item from "./DataRowItem.vue"

  export default {
    name: "DataTable",
    components: {
      data_row_item,
    },

    data() {
      return {}
    },

    computed: {
      ...mapState('data_cleaning', [
        'market_data'
      ]),

    },
  }
</script>
