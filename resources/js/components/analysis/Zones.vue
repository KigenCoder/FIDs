<template>
    <div class="field control">
      <div class="select is-primary is-small">
        <select
            v-model="selectedZone"
            @change="zoneSelected">
          <option value="" disabled selected>Zones</option>
          <option v-for="zone in zones" v-bind:value="zone.id" v-model="selectedZone">
            {{zone.ipc_zone_name}}
          </option>
        </select>
      </div>
    </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    data() {
      return {
        selectedZone: '',
      }
    },
    computed: {
      ...mapState('monthly_analysis', [
        'zones'
      ]),


    },

    mounted() {
      this.$store.dispatch('monthly_analysis/loadZones');
    }
    ,

    methods: {

      zoneSelected() {
        this.$store.commit('monthly_analysis/zoneIdMutation', this.selectedZone)
        this.$store.dispatch('monthly_analysis/loadRegions')

        //Reset data
        this.$store.commit('monthly_analysis/regionsMutation', [])
        this.$store.commit('monthly_analysis/marketsMutation', [])
        this.$store.commit('monthly_analysis/analysisDataMutation', [])
        this.$store.commit('monthly_analysis/metaDataMutation', [])


      },
    },
  }
</script>


