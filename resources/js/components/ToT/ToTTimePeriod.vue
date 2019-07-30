<template>
  <div class="tile is-ancestor is-vertical">

    <div class="tile is-parent">
      <div class="tile is-child">
        <div class="field">
          <div class="control">
            <div class="select is-primary is-small">
              <select v-model="selectedStartPeriod" @change="periodSelected">
                <option value="" disabled selected>From</option>
                <option v-for="year in years" v-bind:value="year.year_name" v-model="selectedStartPeriod">
                  {{year.year_name}}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="tile is-parent">
      <div class="tile is-child">
        <div class="field">
          <div class="control">
            <div class="select is-primary is-small">
              <select v-model="selectedEndPeriod" @change="periodSelected">
                <option value="" disabled selected>To</option>
                <option v-for="year in years" v-bind:value="year.year_name" v-model="selectedEndPeriod">
                  {{year.year_name}}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
  import {mapState, mapGetters, mapMutations} from 'vuex'

  export default {
    name: "TimePeriod",
    data() {
      return {
        selectedStartPeriod: '',
        selectedEndPeriod: '',
      }
    },

    mounted() {
      this.$store.dispatch('monthly_analysis/loadYears')
    },

    computed: {
      ...mapState('monthly_analysis', [
        'years'
      ]),
      ...mapGetters([
        'getIndicatorId'
      ]),

    },


    methods: {

      periodSelected() {

        //Start and end periods are correct - Commit to store
        let startYear = this.selectedStartPeriod
        let endYear = this.selectedEndPeriod


        //Check to see if start year is more than end year
        if (this.selectedStartPeriod <= this.selectedEndPeriod) {

          this.$store.commit('monthly_analysis/totStartYearMutation', startYear)
          this.$store.commit('monthly_analysis/totEndYearMutation', endYear)

          //Get marketID and IndicatorID from store
          let marketIds = this.$store.getters['monthly_analysis/getTotMarketIds']
          let firstIndicatorId = this.$store.getters['monthly_analysis/getToTFirstIndicator']
          let secondIndicatorId = this.$store.getters['monthly_analysis/getToTSecondIndicator']


          if (firstIndicatorId && secondIndicatorId && marketIds) {
            // Indicator and Market good to go - Fetch data for given period e.g 2015 - 2019
            this.$store.dispatch('monthly_analysis/loadToTData')
            this.$store.dispatch('monthly_analysis/loadToTMetaData')

          } else {
            alert("Please select Market(s) and Indicator(S).")
          }

        } else if (startYear && endYear) {
          alert("Check end and start period")
        }


      },
    }
  }
</script>

