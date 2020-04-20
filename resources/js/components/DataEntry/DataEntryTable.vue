<template>
  <div class="container" :key="componentKey">
    <spinner></spinner>
    <table v-if="showTable" class="table is-bordered is-hoverable is-fullwidth small-font is-size-7">
      <th>INDICATOR</th>
      <th>WEEK 1</th>
      <th>WEEK 2</th>
      <th>WEEK 3</th>
      <th>WEEK 4</th>
      <th>WEEK 5</th>
      <th>SUPPLY</th>
      <tbody>
      <indicator_list
          v-for="(indicatorListItem, index) in marketIndicators"
          :list_item="indicatorListItem"
          v-bind:key="index">
      </indicator_list>
      </tbody>
    </table>
  </div>


</template>

<script>
  import {mapState} from 'vuex';
  import indicator_list from "./IndicatorList.vue"

  export default {
    name: "DataTable",
    components: {
      indicator_list,

    },

    data() {
      return {
        componentKey: 0,
        showTable: false,
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
            if(state.data_entry.refresh){

              if(marketIndicatorsSize>0){
                //console.log('Force rerender')
                this.forceRerender();
              }

            }
            break

          case 'data_entry/marketIndicatorsMutation':
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
        this.$store.commit('data_entry/refreshPage', false)
      }
    }
  }
</script>
