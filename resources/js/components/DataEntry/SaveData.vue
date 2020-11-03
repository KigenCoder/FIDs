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
      this.$store.dispatch("data_entry/saveData")

    },
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {

      switch (mutation.type) {
        case 'data_entry/marketDataMutation':
          let marketDataSize =  state.data_entry.marketData.length

          if (marketDataSize > 0) {
            this.showComponent = true
          }else{
            this.showComponent = false
          }
          break

        case 'data_entry/updateMarketDataMutation':
          this.showComponent = true
          break

      }
    })
  },


}
</script>
