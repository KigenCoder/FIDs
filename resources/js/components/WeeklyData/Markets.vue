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
      ...mapState('weekly_data', [
        'markets'
      ])
    },


    methods: {
      marketSelected: function () {
        this.$store.commit('weekly_data/marketIdMutation', this.marketId)

        let weekId = this.$store
        let monthId = this.$store.getters['weekly_data/getMonthId']
        let yearName = this.$store.getters['weekly_data/getYearName']

        if(monthId && yearName){//Get data
          this.$store.dispatch('weekly/loadMarketData')
        }
      }

    },


  }
</script>

