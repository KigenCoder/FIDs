<template>

  <div class="tile is-child" v-if="showChart">
    <apexchart
        width="90%"
        height="80%"
        type="line"
        :options="options"
        :series="series">

    </apexchart>
  </div>
</template>

<script>

  import {mapGetters} from 'vuex'

  export default {

    data() {
      return {
        showChart: false,
        series: [],
        options: {
          chart: {
            id: 'TOT Market prices series',
            width: "90%",
            height: "80%",
            type: "line",
          },

          dataLabels: {
            enabled: false,
          },

          stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
          },

          markers: {
            size: 10,
            colors: undefined,
            strokeColors: '#fff',
            strokeWidth: 2,
            strokeOpacity: 0.9,
            fillOpacity: 1,
            discrete: [],
            shape: "square",
            radius: 1,
            offsetX: 0,
            offsetY: 0,
            hover: {
              size: undefined,
              sizeOffset: 3
            }
          },

          xaxis: {
            categories: this.months(),
          },
        },
      }
    },

    computed: {
      ...mapGetters('monthly_analysis', [
        'getIndicatorName'
      ]),
    },

    mounted() {
      this.$store.subscribe((mutation, state) => {
        switch (mutation.type) {
          case 'monthly_analysis/showToTChartDataMutation':
            if (state.monthly_analysis.show_tot_chart_data) {
              this.series = [] // Reset series items
              let chartDataItems = state.monthly_analysis.tot_chart_data

              //For each year create a chart line object
              for (let i = 0; i < chartDataItems.length; i++) {
                let dataItems = []
                let marketPrices = chartDataItems[i].marketPrices

                for (let k = 0; k < marketPrices.length; k++) {
                  let data_value = marketPrices[k].data_value
                  dataItems.push(data_value === undefined ? null : data_value)
                  //console.log(price === '' ? 0: price)
                }

                let seriesItem = {
                  name: chartDataItems[i].year,
                  data: dataItems,
                }
                this.series.push(seriesItem)
              }
              this.showChart = true
              this.$store.commit('monthly_analysis/showToTChartDataMutation', null)
              break;
            }
        }
      })


    },

    methods: {
      closeModal() {
        //console.log('I am not boarding')
        this.isActive = ''
      },


      months() {
        let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']

        return months

      },


    },


  }
</script>

