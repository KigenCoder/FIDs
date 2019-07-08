<template>
  <div class="tile box is-parent is-vertical">
    <table class="table table is-narrow is-bordered is-stripped small-font is-size-7 ">
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

  }
</script>

