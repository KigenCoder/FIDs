<template>
  <div class="container-fluid">
    <button v-if="showComponent" class="button is-info" @click="saveWeeklyData">
      Submit
    </button>
  </div>

</template>

<script>
import {mapState} from 'vuex'

export default {
  name: "SaveData",

  data() {
    return {
      showComponent: false
    }
  },

  methods: {

    saveWeeklyData: function () {
      this.$store.dispatch("weekly_data_entry/saveData")

    },
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {

      switch (mutation.type) {
        case 'weekly_data_entry/marketDataMutation':
          let marketDataSize = state.weekly_data_entry.marketData.length

          if (marketDataSize > 0) {
            this.showComponent = true
          }else{
            this.showComponent = false
          }
          break

        case 'weekly_data_entry/updateMarketDataMutation':
          this.showComponent = true
          break

      }
    })
  },


}
</script>
