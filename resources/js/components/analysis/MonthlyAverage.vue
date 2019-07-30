<template>
  <tr>
    <td v-if="hasElements">Monthly average</td>
    <td v-for="average in averages">{{average.data_value}}</td>
  </tr>
</template>

<script>


  export default {
    data() {
      return {
        averages: [],
      }
    },


    computed: {
      hasElements: function () {
        if (this.averages !== undefined && this.averages.length > 0) {
          return true
        }
        return false
      }
    },


    mounted() {
      this.$store.subscribe((mutation, state) => {
           //Monthly analysis
        if (mutation.type == 'monthly_analysis/metaDataMutation') {
          if (state.monthly_analysis['meta_data']) {
            this.averages = state.monthly_analysis['meta_data'].averages
          }
        }
        //ToT analysis
        if(mutation.type == 'monthly_analysis/totMetaDataMutation'){
          if(state.monthly_analysis['tot_meta_data']){
            this.averages= state.monthly_analysis['tot_meta_data'].averages
            //console.log(state.monthly_analysis['tot_meta_data'].averages)

          }

        }
      })
    },
  }
</script>

