<template>

  <div class="columns">
    <div class="column">
      <div class=" field control">
        <div class="select is-primary is-small">
          <select v-model="year_name" @change="yearSelected">
            <option value="" disabled selected>Year</option>
            <option v-for="(year) in years" v-bind:value="year.year_name">
              {{ year.year_name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="column">
      <div class=" field control">
        <div class="select is-primary is-small">
          <select v-model="month_id" @change="monthSelected">
            <option value="" disabled selected>Month</option>
            <option
                v-for="(month) in months"
                v-bind:value="month.month_id">
              {{ month.month }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="column">
      <div class=" field control">
        <div class="select is-primary is-small">
          <select v-model="week_id" @change="weekSelected">
            <option value="" disabled selected>Week</option>
            <option
                v-for="(week) in weeks"
                v-bind:value="week.week_id">
              {{ week.week }}
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
  name: 'TimePeriod',
  data() {
    return {
      months: [],
      weeks: [],
      month_id: '',
      week_id: '',
      year_name: '',
    }
  },
  computed: {
    ...mapState('monthly_analysis', ['years'])
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

    this.weeks = [
      {week_id: 1, week: "WEEK 1"},
      {week_id: 2, week: "WEEK 2"},
      {week_id: 3, week: "WEEK 3"},
      {week_id: 4, week: "WEEK 4"},
      {week_id: 5, week: "WEEK 5"},
    ]


  },

  methods: {

    weekSelected: function (){
      //Commit to the store the current week ID
      this.$store.commit('weekly_data_entry/weekIdMutation', this.week_id)
      this.$store.commit('weekly_data_entry/refreshPageMutation', true)

      let marketId = this.$store.getters['weekly_data_entry/getMarketId']
      let yearName = this.$store.getters['weekly_data_entry/getYearName']
      let monthId = this.$store.getters["weekly_data_entry/getMonthId"]

      if (yearName && marketId && monthId) {//Get market data
        this.$store.dispatch('weekly_data_entry/loadMarketIndicators')
      }

    },
    monthSelected: function () {
      //Commit to the store the current month ID
      this.$store.commit('weekly_data_entry/monthIdMutation', this.month_id)
      this.$store.commit('weekly_data_entry/refreshPageMutation', true)

      let marketId = this.$store.getters['weekly_data_entry/getMarketId']
      let yearName = this.$store.getters['weekly_data_entry/getYearName']
      let weekId = this.$store.getters["weekly_data_entry/getWeekId"]

      if (yearName && marketId && weekId) {//Get market data
        this.$store.dispatch('weekly_data_entry/loadMarketIndicators')
      }

    },
    yearSelected: function () {
      this.$store.commit('weekly_data_entry/yearNameMutation', this.year_name)
      this.$store.commit('weekly_data_entry/refreshPageMutation', true)


      let marketId = this.$store.getters['weekly_data_entry/getMarketId']
      let monthId = this.$store.getters['weekly_data_entry/getMonthId']
      let weekId = this.$store.getters["weekly_data_entry/getWeekId"]

      if (monthId && marketId && weekId) {//Get market data
        this.$store.dispatch('weekly_data_entry/loadMarketIndicators')
      }
    }
  },

}
</script>
