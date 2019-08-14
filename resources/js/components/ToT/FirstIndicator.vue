<template>
  <div class="field control">
    <div class="select is-primary is-small" style="width: 100px">
      <select v-model="selectedIndicator" @change="indicatorSelected">
        <option value="" disabled selected>First Indicator</option>
        <option v-for="indicator in indicators" v-bind:value="indicator.id">
          {{indicator.indicator_business_name}}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "Indicators",
    data() {
      return {
        selectedIndicator: ''
      }
    },

    mounted() {
      //this.$store.dispatch('loadIndicators')
    },
    computed: {
      ...mapState('monthly_analysis', [
        'indicators'
      ])

    },
    methods: {
      indicatorSelected() {
        //Reset current data
        this.$store.commit('monthly_analysis/totAnalysisDataMutation', [])
        this.$store.commit('monthly_analysis/totMetaDataMutation', [])

        //Set current indicator
        this.$store.commit('monthly_analysis/totFirstIndicatorMutation', this.selectedIndicator)
        let secondIndicator = this.$store.getters['monthly_analysis/getToTSecondIndicator']
        let startYear = this.$store.getters['monthly_analysis/getToTStartYear']
        let endYear = this.$store.getters['monthly_analysis/getToTEndYear']
        let market_ids = this.$store.getters['monthly_analysis/getToTMarketIds']


        if (startYear && endYear && secondIndicator && market_ids.length > 0) {
          //load data if indicator, start and end year determined
          this.$store.dispatch('monthly_analysis/loadToTData')
          this.$store.dispatch('monthly_analysis/loadToTMetaData')
        }

      },
    }

  }
</script>

