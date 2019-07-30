<template>
  <div class=" field control">
    <div class="select is-primary is-small">
      <select v-model="selectedMarketType" @change="typeSelected">
        <option value="" disabled selected>Market Type</option>
        <option v-for="type in marketTypes" v-bind:value="type.id">
          {{type.type}}
        </option>
      </select>
    </div>
  </div>

</template>

<script>
  export default {
    data() {
      return {
        marketTypes: [
          {"id": 1, "type": "Main Market"},
          {"id": 2, "type": "SLIMS"},
        ],
        selectedMarketType: '',
      }
    },

    methods: {
      typeSelected: function () {

        //Update region ID state
        this.$store.commit('monthly_analysis/marketSystemMutation', this.selectedMarketType);


        let regionId = this.$store.getters['monthly_analysis/getRegionId']

        if (regionId !== undefined && parseInt(regionId) > 0) {

          this.$store.commit('monthly_analysis/marketsMutation', [])

          //Fetch markets for given Region
          this.$store.dispatch('monthly_analysis/loadMarkets')
        }

        //Fetch indicators based on market type Main Market, SLIM
        this.$store.dispatch('monthly_analysis/loadIndicators')

        //Reset data
        this.$store.commit('monthly_analysis/indicatorsMutation', [])
        this.$store.commit('monthly_analysis/analysisDataMutation', [])
        this.$store.commit('monthly_analysis/metaDataMutation', [])

      },
    }
  }
</script>
