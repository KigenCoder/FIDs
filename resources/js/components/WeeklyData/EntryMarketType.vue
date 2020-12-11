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
    name: 'weekly_market_type',
    data() {
      return {
        marketTypes: [
          {"id": 1, "type": "Main Market"},
          {"id": 2, "type": "SLIMS I"},
        ],
        marketTypeId: '',
      }
    },

    methods: {
      typeSelected: function () {

        this.$store.commit('weekly_data_entry/marketTypeIdMutation', this.marketTypeId)
        //Fetch markets
        this.$store.dispatch('weekly_data_entry/loadMarkets');


        //Reset data
        this.$store.commit('weekly_data_entry/marketIndicatorsMutation', [])
        this.$store.commit('weekly_data_entry/marketDataMutation', [])
        this.$store.commit('weekly_data_entry/marketIdMutation', '');

      },
    }
  }
</script>
