<template>
  <tr>
    <td v-if="hasElements">% of Average</td>
    <td v-for="data_item in data_items">{{data_item.data_value}}</td>
  </tr>
</template>

<script>


  export default {
    name: "PercentageOfLTM",
    data() {
      return {
        data_items: [],
      }
    },


    computed: {
      hasElements: function () {
        if (this.data_items !== undefined && this.data_items.length > 0) {
          return true
        }
        return false
      }
    },


    mounted() {
      this.$store.subscribe((mutation, state) => {
       //Monthly analysis
        if (mutation.type === 'monthly_analysis/metaDataMutation') {
          if (state.monthly_analysis['meta_data']) {
            this.data_items = state.monthly_analysis['meta_data'].percentage_of_average

          }
        }

        //ToT Analysis
        if (mutation.type === 'monthly_analysis/totMetaDataMutation') {
          if (state.monthly_analysis['tot_meta_data']) {
            this.data_items = state.monthly_analysis['tot_meta_data'].percentage_of_average

          }
        }
      })
    },
  }
</script>

