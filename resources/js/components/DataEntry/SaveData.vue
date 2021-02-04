<template>
  <div class="container-fluid">
    <button v-if="showComponent" class="button is-info" @click="saveMonthlyData">
      Submit
    </button>
  </div>

</template>

<script>
import {mapState} from 'vuex'

export default {
  name: "SaveMonthlyData",

  data() {
    return {
      showComponent: false
    }
  },

  methods: {

    saveMonthlyData: function () {
      let marketTypeId = this.$store.getters['data_entry/getMarketTypeId']

      if (marketTypeId === 3) {
        this.$store.dispatch("data_entry/saveSlims")

      } else {
        this.$store.dispatch("data_entry/saveData")

      }

    },
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {

      let marketDataSize = state.data_entry.marketData.length

      switch (mutation.type) {
        case 'data_entry/marketDataMutation':
          if (marketDataSize > 0) {
            this.showComponent = true

          }
          break

        case 'data_entry/updateMarketDataMutation':
          if (marketDataSize > 0) {
            this.showComponent = true

          }
          break

        case 'data_entry/updateSlimDataMutation':
          if (marketDataSize > 0) {
            this.showComponent = true

          }
          break


      }
    })
  },


}
</script>
