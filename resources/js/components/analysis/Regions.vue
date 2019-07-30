<template>
  <div class=" field control">
    <div class="select is-primary is-small">
      <select v-model="selectedRegion" @change="regionSelected">
        <option value="" disabled selected>Regions</option>
        <option v-for="region in regions" v-bind:value="region.id">
          {{region.region_name}}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "regions",
    data() {
      return {
        selectedRegion: ''
      }
    },

    computed: {
      ...mapState('monthly_analysis', [
        'regions'
      ])
    },

    methods: {
      regionSelected() {
        //Update region ID state
        this.$store.commit('monthly_analysis/regionIdMutation', this.selectedRegion)

        let marketType = this.$store.getters['monthly_analysis/getMarketSystemType']

        if (marketType !== undefined && parseInt(marketType) > 0) {

          //Reset markets
          this.$store.commit('monthly_analysis/marketsMutation', [])

          //Fetch markets
          this.$store.dispatch('monthly_analysis/loadMarkets')


        }


      }

    }
  }
</script>

