<template>
  <div class="container" :key="componentKey">
    <table class="table is-bordered is-narrow is-hoverable is-fullwidth">
      <th>INDICATOR</th>
      <th>WEEK 1</th>
      <th>WEEK 2</th>
      <th>WEEK 3</th>
      <th>WEEK 4</th>
      <th>WEEK 5</th>
      <th>SUPPLY</th>
      <tbody>
      <indicator_list
          v-for="(indicatorListItem, index) in marketIndicators"
          :list_item="indicatorListItem"
          v-bind:key="index">
      </indicator_list>
      </tbody>
    </table>
  </div>


</template>

<script>
  import {mapState} from 'vuex';
  import indicator_list from "./IndicatorList.vue"

  export default {
    name: "DataTable",
    components: {
      indicator_list,

    },

    data() {
      return {
        componentKey: 0,
      }
    },

    computed: {
      ...mapState('data_entry', [
        'marketIndicators'
      ]),

    },
    mounted() {
      this.$store.subscribe((mutation, state) => {
        if (mutation.type === 'data_entry/refreshPage') {
          this.forceRerender()
        }

      })
    },
    methods: {
      forceRerender() {
        this.componentKey += 1;
      }
    }
  }
</script>
