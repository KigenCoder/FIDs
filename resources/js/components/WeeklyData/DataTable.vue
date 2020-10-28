<template>
  <div class="container">
    <spinner></spinner>
    <table v-if="showTable" class="table is-bordered is-hoverable is-fullwidth small-font is-size-7">
      <th>INDICATOR</th>
      <th>WEEK 1</th>
      <th>WEEK 2</th>
      <th>WEEK 3</th>
      <th>WEEK 4</th>
      <th>WEEK 5</th>
      <th>Previous month avg</th>
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
import data_row_item from "./DataRow.vue"

export default {
  name: "DataTable",
  components: {
    data_row_item,
  },

  data() {
    return {
      showTable: false,
      componentKey: 0
    }
  },

  mounted() {
    this.$store.subscribe((mutation, state) => {
      switch (mutation.type) {
        case  'weekly_data/marketDataMutation':
          if (state.weekly_data.market_data.length > 0) {
            this.showTable = true
          }

          break;
        case 'weekly_data/refreshPage':
          if (state.weekly_data.refresh) {
            this.forceRerender()
          }

      }

    })
  },

  computed: {
    ...mapState('weekly_data', [
      'market_data'
    ]),

  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
      this.$store.commit('weekly_data/refreshPage', false)
    }
  }
}
</script>
