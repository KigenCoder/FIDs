<template>
  <div class="container" :key="componentKey">
    <spinner></spinner>
    <table v-if="showTable" class="table is-bordered is-hoverable is-fullwidth small-font is-size-7">
      <th>INDICATOR</th>
      <th>Monthly</th>
      <th>Location</th>
      <th>Key Informant</th>
      <th>Triangulation</th>
      <th>Data Trust level</th>

      <tbody>
      <slims_entry_rows
          v-for="(indicatorListItem, index) in marketIndicators"
          :list_item="indicatorListItem"
          v-bind:key="index">
      </slims_entry_rows>
      <tr>
        <td>Comments</td>
        <td>
          <input type="text" v-model="comments" @blur="saveComments">
        </td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      </tbody>
    </table>
  </div>


</template>

<script>
import {mapState} from 'vuex';
import slims_entry_rows from "./SlimsEntryRow.vue"

export default {
  name: "SlimsDataTable",
  components: {
    slims_entry_rows,

  },

  data() {
    return {
      componentKey: 0,
      showTable: false,
      comments: '',
    }
  },

  computed: {
    ...mapState('data_entry', [
      'marketIndicators'
    ]),

  },
  mounted() {
    this.$store.subscribe((mutation, state) => {
      let marketIndicatorsSize = state.data_entry.marketIndicators.length

      switch (mutation.type) {
        case 'data_entry/refreshPage':
          if (state.data_entry.refresh) {

            if (marketIndicatorsSize > 0) {
              //console.log('Force rerender')
              this.forceRerender();
            }

          }
          break

        case 'data_entry/marketIndicatorsMutation':

          if (marketIndicatorsSize > 0 && state.data_entry.marketTypeId === 3) {
            this.showTable = true
          }
          break


        case 'data_entry/marketTypeIdMutation':
          if (state.data_entry.marketTypeId !== 3) {
            this.showTable = false //Hide for SLIMS II
          }

          if (state.data_entry.marketTypeId === 3 && marketIndicatorsSize > 0) {
            this.showTable = true
          }

      }
    })
  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
      this.$store.commit('data_entry/refreshPage', false)
    },

    saveComments() {
      let year_name = this.$store.getters['data_entry/getYearName']
      let month_id = this.$store.getters['data_entry/getMonthId']
      let market_id = this.$store.getters['data_entry/getMarketId']

      let commentsObject = {
        year_name: year_name,
        month_id: month_id,
        comments: this.comments,
        market_id: market_id,
      }
      this.$store.commit('data_entry/commentsMutation', commentsObject)
    }
  }
}
</script>
