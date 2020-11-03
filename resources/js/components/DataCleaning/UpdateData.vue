<template>
  <div class="container-fluid">
    <button v-if="showComponent" class="button is-info" @click="updateData">
      Submit
    </button>
  </div>

</template>

<script>
import {mapState} from 'vuex'

export default {
  name: "btnUpdateData",

  data() {
    return {
      showComponent: false
    }
  },

  methods: {

    updateData: function () {
      this.$store.dispatch("data_cleaning/updateData")

    },
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {

      switch (mutation.type) {
        case 'data_cleaning/marketUpdatesMutation':
          let marketDataSize =  state.data_cleaning.marketUpdates.length

          if (marketDataSize > 0) {
            this.showComponent = true
          }else{
            this.showComponent = false
          }
          break


      }
    })
  },


}
</script>
