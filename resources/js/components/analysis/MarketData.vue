<template>
  <div class="container">
    <spinner></spinner>
    <table class="table table is-fullwidth is-bordered is-stripped small-font is-size-7">
      <caption style="color: blue">
        <strong>{{getIndicatorName}}</strong>
      </caption>
      <thead>
      <tr>
        <th v-for="(th) in tableHeader">{{th}}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(analysisData) in analysis_data ">
        <td>{{analysisData.year}}</td>

        <data-cell
            v-for="(priceData, index) in analysisData.marketPrices"
            :data="priceData"
            v-bind:key="index">
        </data-cell>
      </tr>
      <RowBoundary></RowBoundary>
      <monthly-average></monthly-average>
      <preceding-months></preceding-months>
      <same-months></same-months>
      <PercentageOfLTM></PercentageOfLTM>
      <TwelveMonthMax></TwelveMonthMax>
      <TwelveMonthMin></TwelveMonthMin>
      <SixMonthMax></SixMonthMax>
      <SixMonthMin></SixMonthMin>
      <SixMonthDiff></SixMonthDiff>
      </tbody>
    </table>


  </div>


</template>

<script>

  import {mapState, mapGetters} from 'vuex'
  import DataCell from "./PriceDataCell.vue";
  import RowBoundary from "./RowBoundary.vue"
  import MonthlyAverage from "./MonthlyAverage.vue"
  import PrecedingMonths from "./PrecedingMonths.vue"
  import SameMonths from "./SameMonths.vue"
  import PercentageOfLTM from "./PercentageOfLTM.vue"
  import TwelveMonthMax from "./TwelveMonthMax.vue"
  import TwelveMonthMin from "./TwelveMonthMin.vue"
  import SixMonthMax from "./SixMonthMax.vue"
  import SixMonthMin from "./SixMonthMin.vue"
  import SixMonthDiff from "./SixMonthDiff.vue"
  import VueLoading from 'vuejs-loading-plugin'


  // overwrite defaults
  Vue.use(VueLoading, {
    dark: true, // default false
    text: 'Fuck.....!!!!!', // default 'Loading'
    loading: false, // default false
    //customLoader: myVueComponent, // replaces the spinner and text with your own
    background: 'rgb(255,255,255)', // set custom background
    classes: ['myclass'] // array, object or string
  })



  export default {
    components: {
      MonthlyAverage,
      PrecedingMonths,
      SameMonths,
      DataCell,
      RowBoundary,
      PercentageOfLTM,
      TwelveMonthMax,
      TwelveMonthMin,
      SixMonthMax,
      SixMonthMin,
      SixMonthDiff,
    },


    computed: {
      ...mapState('monthly_analysis', [
        'analysis_data'
      ]),

      ...mapGetters('monthly_analysis', [
        'getIndicatorName'
      ]),
    },

    data() {
      return {
        ltm: [],
        tableHeader: [
          "Year",
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",],

      }
    },

    mounted() {
      //this.$loading(true)
    }

  }
</script>

