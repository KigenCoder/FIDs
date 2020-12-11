<template>
  <div class=" field control">
    <div class="select is-primary is-small">
      <select v-model="marketTypeId" @change="typeSelected">
        <option value="" disabled selected>Market Type</option>
        <option v-for="type in marketTypes" v-bind:value="type.id">
          {{ type.type }}
        </option>
      </select>
    </div>
  </div>

</template>

<script>
export default {
  data() {
    return {
      name: 'weekly_market_types',
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

      this.$store.commit('weekly_data/marketTypeIdMutation', this.marketTypeId)
      //Fetch markets
      this.$store.dispatch('weekly_data/loadMarkets');

      //let marketId = this.$store.getters['weekly_data/getMarketId']

      //Reset data
      this.$store.commit('weekly_data/marketDataMutation', [])
    },
  }
}
</script>
