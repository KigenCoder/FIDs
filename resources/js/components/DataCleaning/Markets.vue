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
      ...mapState('data_cleaning', [
        'markets'
      ])
    },


    methods: {
      marketSelected: function () {
        this.$store.commit('data_cleaning/marketIdMutation', this.marketId)

        let monthId = this.$store.getters['data_cleaning/getMonthId']
        let yearName = this.$store.getters['data_cleaning/getYearName']

        if(monthId && yearName){//Get data
          this.$store.dispatch('data_cleaning/loadMarketData')
        }
      }

    },


  }
</script>

