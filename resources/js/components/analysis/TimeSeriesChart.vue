<template>

  <div class="modal modal-full-screen modal-fx-fadeInScale" :class="isActive" id="modal-fadeInScale-fs">
    <div class="modal-content modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{{getIndicatorName}}</p>
        <button v-on:click="closeModal" class="modal-button-close delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <!-- Modal card body -->
        <line-chart :width="300" :height="300" :chart-data="chartDisplayData"></line-chart>
      </section>
      <footer class="modal-card-foot">
        <button v-on:click="closeModal" class="modal-button-close button">Cancel</button>
      </footer>
    </div>
  </div>
</template>

<script>

  import {mapGetters} from 'vuex'
  import LineChart from './LineChart.js'


  export default {
    components: {
      LineChart
    },
    data() {
      return {
        isActive: '',
        chartDisplayData: {},
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
          case 'monthly_analysis/showChartDataMutation':
            if (state.monthly_analysis.show_chart_data) {
              let chartDataItems = state.monthly_analysis.chart_data
              let labels = []
              let dataSets = []


              //For each year create a chart line object
              for (let i = 0; i < chartDataItems.length; i++) {

                let dataItems = []
                let labelItems = []

                let marketPrices = chartDataItems[i].marketPrices

                for (let k = 0; k < marketPrices.length; k++) {
                  let month_id = marketPrices[k].month_id
                  labelItems.push(this.monthName(month_id))
                  dataItems.push(marketPrices[k].price)
                }

                labels = labelItems

                let dataSet = {
                  label: chartDataItems[i].year,
                  data: dataItems,
                  //backgroundColor: this.randomColor(),
                  borderColor: this.randomColor(),
                  borderWidth: 3,
                }

                dataSets.push(dataSet)

              }

              this.chartDisplayData = {
                labels: labels,
                datasets: dataSets,
                options: {
                  responsive: true,
                  lineTension: 1,
                  scales: {
                    yAxes: [{
                      ticks: {
                        beginAtZero: true,
                        padding: 5,
                      }
                    }]
                  }
                }
              }
              this.isActive = 'is-active'
              this.$store.commit('monthly_analysis/showChartDataMutation', null)
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

      randomColor() {

        let rgbColors = [
          '#e6194b',
          '#3cb44b',
          '#ffe119',
          '#4363d8',
          '#f58231',
          '#911eb4',
          '#46f0f0',
          '#f032e6',
          '#bcf60c',
          '#fabebe',
          '#008080',
          '#e6beff',
          '#9a6324',
          '#fffac8',
          '#800000',
          '#aaffc3',
          '#808000',
          '#000075',
          '#000000'
        ]

        return rgbColors[Math.floor(Math.random() * rgbColors.length)];

      },

      monthName(month_id) {
        let month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        return month[month_id - 1]
      },


    },


  }
</script>

