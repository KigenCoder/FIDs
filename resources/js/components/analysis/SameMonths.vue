<template>
  <tr>
    <td v-if="hasElements">% of same month</td>
    <td v-for="data_item in data_items">{{data_item.data_value}}</td>
  </tr>
</template>

<script>


  export default {
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
         //Market analysis
        if (mutation.type === 'monthly_analysis/metaDataMutation') {
          if (state.monthly_analysis['meta_data']) {
            this.data_items = state.monthly_analysis['meta_data'].same_months

          }
        }

          //ToT analysis
        if (mutation.type === 'monthly_analysis/totMetaDataMutation') {
          if (state.monthly_analysis['tot_meta_data']) {
            this.data_items = state.monthly_analysis['tot_meta_data'].same_months

          }
        }
      })
    },
  }
</script>

