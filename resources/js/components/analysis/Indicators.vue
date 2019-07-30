<template>
  <div class="field control">
    <div class="select is-primary is-small" style="width: 100px">
      <select v-model="selectedIndicator" @change="indicatorSelected">
        <option value="" disabled selected>Indicators</option>
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
        this.$store.commit('monthly_analysis/analysisDataMutation', [])
        this.$store.commit('monthly_analysis/metaDataMutation', [])


        let i
        for (i = 0; i < this.indicators.length; i++) {
          let indicator = this.indicators[i]

          if (indicator.id == this.selectedIndicator) {
            //Get indicator name
            this.$store.commit('monthly_analysis/indicatorNameMutation', indicator.indicator_business_name)
          }
        }


        //Set current indicator
        this.$store.commit('monthly_analysis/indicatorIdMutation', this.selectedIndicator)
        let startYear = this.$store.getters['monthly_analysis/getStartYear']
        let endYear = this.$store.getters['monthly_analysis/getEndYear']
        let market_ids = this.$store.getters['monthly_analysis/getMarketIds']


        if (startYear && endYear && market_ids.length > 0) {
          //load data if indicator, start and end year determined
          this.$store.dispatch('monthly_analysis/loadData')
          this.$store.dispatch('monthly_analysis/loadMetaData')
        }

      }
    }

  }
</script>

