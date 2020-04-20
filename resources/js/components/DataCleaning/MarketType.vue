<template>
  <div class=" field control">
    <div class="select is-primary is-small">
      <select v-model="marketTypeId" @change="typeSelected">
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
          {"id": 2, "type": "SLIMS I"},
          {"id": 3, "type": "SLIMS II"},
        ],
        marketTypeId: '',
      }
    },

    methods: {
      typeSelected: function () {

        this.$store.commit('data_cleaning/marketTypeIdMutation', this.marketTypeId)
        //Fetch markets
        this.$store.dispatch('data_cleaning/loadMarkets');
        let marketId = this.$store.getters['data_cleaning/getMarketId']

        //Reset data
        this.$store.commit('data_cleaning/marketDataMutation', [])
      },
    }
  }
</script>
