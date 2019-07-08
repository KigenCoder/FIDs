<template>
  <div class="tile is-child is-vertical">
    <div class=" tile is-child">
      <button @click="showChartData" class="button is-link align-center"> Show Chart</button>
      <p title="subtitle is-5">Select series below</p>
    </div>
    <div class="scroll-y">
      <ul>
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
          case 'monthly_analysis/analysisDataMutation':
            let analysisData = state.monthly_analysis.analysis_data
            if (analysisData.length> 0)
              this.years = [] // Reset years array

              for(let i=0; i<analysisData.length; i++){
                //console.log(analysisData[i])
                this.years.push(analysisData[i].year)
              }

              this.years.sort().reverse()
              break;
        }
      })

    },


    methods: {
      selectSeries() {

        let analysisData = this.$store.getters['monthly_analysis/getAnalysisData']

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
          this.$store.commit('monthly_analysis/chartDataMutation', chartData)

        }

      },

      showChartData() {
        let chartData = this.$store.getters['monthly_analysis/getChartData']
        //console.log(chartData);

        if (this.selected.length > 0 && chartData.length > 0) {
          //Display chart data
          this.$store.commit('monthly_analysis/showChartDataMutation', 1)

        }

      },
    }

  }
</script>
