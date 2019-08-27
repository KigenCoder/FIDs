<template>

  <div class="columns">
    <div class="column">
      <div class=" field control">
        <div class="select is-primary is-small">
          <select v-model="month_id" @change="monthSelected">
            <option value="" disabled selected>Month</option>
            <option
                v-for="(month) in months"
                v-bind:value="month.month_id">
              {{month.month}}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="column">
      <div class=" field control">
        <div class="select is-primary is-small">
          <select v-model="year_name" @change="yearSelected">
            <option value="" disabled selected>Year</option>
            <option v-for="(year) in years" v-bind:value="year.year_name">
              {{year.year_name}}
            </option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: 'MonthYears',
    data() {
      return {
        months: [],
        month_id: '',
        year_name: '',
      }
    },
    computed: {
      ...mapState('monthly_analysis', [
        'years'
      ])
    },

    mounted() {

      this.$store.dispatch('monthly_analysis/loadYears')

      this.months = [
        {month_id: 1, month: "January"},
        {month_id: 2, month: "February"},
        {month_id: 3, month: "March"},
        {month_id: 4, month: "April"},
        {month_id: 5, month: "May"},
        {month_id: 6, month: "June"},
        {month_id: 7, month: "July"},
        {month_id: 8, month: "August"},
        {month_id: 9, month: "September"},
        {month_id: 10, month: "October"},
        {month_id: 11, month: "November"},
        {month_id: 12, month: "December"},
      ]


    },

    methods: {
      monthSelected: function () {
        //Commit to the store the current month ID
        this.$store.commit('data_cleaning/monthIdMutation', this.month_id)

        this.$store.commit('data_cleaning/refreshPage', true)

        let yearName = this.$store.getters['data_cleaning/getYearName']
        let marketId = this.$store.getters['data_cleaning/getMarketId']

        if (yearName && marketId) {//Get market data
          this.$store.dispatch('data_cleaning/loadMarketData')
        }

      },
      yearSelected: function () {
        this.$store.commit('data_cleaning/yearNameMutation', this.year_name)
        let monthId = this.$store.getters['data_cleaning/getMonthId']
        let marketId = this.$store.getters['data_cleaning/getMarketId']

        if (monthId && marketId) {//Get market data
          this.$store.dispatch('data_cleaning/loadMarketData')
        }
      }
    },

  }
</script>
