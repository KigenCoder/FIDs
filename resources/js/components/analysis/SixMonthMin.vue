<template>
  <tr>
    <td v-if="hasElements">6 Months Min</td>
    <td v-for="data_item in data_items">{{data_item.data_value}}</td>
  </tr>
</template>

<script>


  export default {
    name: "SixMonthMin",
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

        if (mutation.type === 'monthly_analysis/metaDataMutation') {
          if (state.monthly_analysis['meta_data']) {
            let max_min = state.monthly_analysis['meta_data'].six_months_min_max

            if (max_min) {
              this.data_items = []
              for (let i = 0; i < max_min.length; i++) {
                let min_object = max_min[i].min
                this.data_items.push(min_object)
              }
            }

          }
        }
      })
    },
  }
</script>

