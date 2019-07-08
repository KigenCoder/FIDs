<template>
    <div class="field control">
      <div class="select is-primary is-small">
        <select v-model="selectedMarket" @change="marketSelected" >
          <option value="" disabled selected>Markets</option>
          <option v-for="market in markets"  v-bind:value="market.id">
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
        selectedMarket: ''
      }
    },

    computed: {
      ...mapState('monthly_analysis', [
        'markets'
      ])
    },
    methods: {
      marketSelected() {
       //Update market ID to select Main markets/SLIMS
        this.$store.commit('monthly_analysis/marketIdMutation', this.selectedMarket);

        //Fetch indicators based on market type Main Market, SLIM
        this.$store.dispatch('monthly_analysis/loadIndicators')

        //Reset data
        this.$store.commit('monthly_analysis/analysisDataMutation', [])
        this.$store.commit('monthly_analysis/metaDataMutation', [])


      }
    },
  }
</script>

