<template>
  <div class="container">
    <spinner></spinner>
    <table class="table is-fullwidth is-bordered is-stripped is-size-7 ">
      <caption style="color: blue">
        <strong>{{getIndicatorName}}</strong>
      </caption>
      <thead>
      <tr>
        <th v-for="(th) in tableHeader">{{th}}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(totData) in tot_data ">
        <td>{{totData.year}}</td>

        <data-cell
            v-for="(priceData, index) in totData.marketPrices"
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
  import DataCell from "./ToTDataCell.vue";
  import RowBoundary from "./../analysis/RowBoundary.vue"
  import MonthlyAverage from "./../analysis/MonthlyAverage.vue"
  import PrecedingMonths from "./../analysis/PrecedingMonths.vue"
  import SameMonths from "./../analysis/SameMonths.vue"
  import PercentageOfLTM from "./../analysis/PercentageOfLTM.vue"
  import TwelveMonthMax from "./../analysis/TwelveMonthMax.vue"
  import TwelveMonthMin from "./../analysis/TwelveMonthMin.vue"
  import SixMonthMax from "./../analysis/SixMonthMax.vue"
  import SixMonthMin from "./../analysis/SixMonthMin.vue"
  import SixMonthDiff from "./../analysis/SixMonthDiff.vue"


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
        'tot_data'
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

