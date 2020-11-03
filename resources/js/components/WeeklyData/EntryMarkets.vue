<template>
  <div class=" field control">
    <div class="select is-primary is-small">
      <select v-model="marketId" @change="marketSelected">
        <option value="" disabled selected>Markets</option>
        <option v-for="(market) in markets" v-bind:value="market.id">
            {{market.market_name}}
        </option>
      </select>
    </div>
  </div>

</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "markets",
    data() {
      return {
        marketId: '',
      }
    },

    computed: {
      ...mapState('weekly_data_entry', [
        'markets'
      ])
    },

    methods: {
      marketSelected: function () {

        //Reset data
        this.$store.commit('weekly_data_entry/marketIndicatorsMutation', [])
        this.$store.commit('weekly_data_entry/marketDataMutation', [])

        //Now commit
        this.$store.commit('weekly_data_entry/marketIdMutation', this.marketId)
        this.$store.commit('weekly_data_entry/refreshPageMutation', true)




        let monthId = this.$store.getters['weekly_data_entry/getMonthId']
        let yearName = this.$store.getters['weekly_data_entry/getYearName']
        let weekId = this.$store.getters['weekly_data_entry/getWeekId']


        if(weekId && monthId && yearName){//Get market indicators
          this.$store.dispatch('weekly_data_entry/loadMarketIndicators')
        }

      }




    },


  }
</script>

