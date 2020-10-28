<template>
  <div class="container" :key="componentKey">
    <spinner></spinner>
    <table v-if="showTable" class="table is-bordered is-hoverable is-fullwidth small-font is-size-7">
      <th>INDICATOR</th>
      <th>Weekly Data</th>
      <tbody>
      <indicator_row
          v-for="(indicatorListItem, index) in marketIndicators"
          :list_item="indicatorListItem"
          v-bind:key="index">
      </indicator_row>
      </tbody>
    </table>
  </div>


</template>

<script>
  import {mapState} from 'vuex';
  import indicator_row from "./DataEntryRow.vue"

  export default {
    name: "DataTable",
    components: {
      indicator_row,

    },

    data() {
      return {
        componentKey: 0,
        showTable: false,
      }
    },

    computed: {
      ...mapState('weekly_data_entry', ['marketIndicators']),

    },
    mounted() {
      this.$store.subscribe((mutation, state) => {
        let marketIndicatorsSize = state.weekly_data_entry.marketIndicators.length
        switch (mutation.type) {
          case 'weekly_data_entry/refreshPage':
            if(state.weekly_data_entry.refresh){

              if(marketIndicatorsSize>0){
                //console.log('Force rerender')
                this.forceRerender();
              }

            }
            break

          case 'weekly_data_entry/marketIndicatorsMutation':
            if (marketIndicatorsSize  > 0) {
              this.showTable = true
              break
            }
        }
      })
    },
    methods: {
      forceRerender() {
        this.componentKey += 1;
        this.$store.commit('weekly_data_entry/refreshPage', false)
      }
    }
  }
</script>
