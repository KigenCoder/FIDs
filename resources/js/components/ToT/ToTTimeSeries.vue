<template>
  <div v-if="seriesReady" class="field control">
    <button @click="showChartData" class="button is-small is-link is-inverted">
      Select series and click to view chart
    </button>

    <ul class="box-scroll">
      <li v-for="year in years">
        <input
            type="checkbox"
            v-bind:value="year"
            v-model="selected"
            @change="selectSeries()"
        >
        {{year}}
      </li>
    </ul>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "TimeSeries",
    data() {
      return {
        selected: [],
        years: [],
        seriesReady: false,
      }
    },

    computed: {
      ...mapState('monthly_analysis', [
        'chart_data'
      ]),


    },


    mounted() {
      this.$store.subscribe((mutation, state) => {
        switch (mutation.type) {
          case 'monthly_analysis/totAnalysisDataMutation':
            let analysisData = state.monthly_analysis.tot_data
            if (analysisData.length > 0) {
              this.seriesReady = true
              this.years = [] // Reset years array

              for (let i = 0; i < analysisData.length; i++) {
                //console.log(analysisData[i])
                this.years.push(analysisData[i].year)
              }

              this.years.sort().reverse()
              break;
            }
        }
      })

    },


    methods: {
      selectSeries() {
        let analysisData = this.$store.getters['monthly_analysis/getToTAnalysisData']
        let chartData = []
        if (this.selected.length > 0 && analysisData.length > 0) {
          for (let i = 0; i < this.selected.length; i++) {
            let currentYear = this.selected[i];

            for (let k = 0; k < analysisData.length; k++) {
              let dataItem = analysisData[k];
              if (dataItem.year === currentYear) {
                chartData.push(dataItem)
              }
            }
          }


          //Commit it to the store
          this.$store.commit('monthly_analysis/totChartDataMutation', chartData)

        }

      },

      showChartData() {
        let chartData = this.$store.getters['monthly_analysis/getToTChartData']
        console.log(chartData);

        if (this.selected.length > 0 && chartData.length > 0) {
          //Display chart data
          this.$store.commit('monthly_analysis/showToTChartDataMutation', 1)

        }

      },
    }

  }
</script>
