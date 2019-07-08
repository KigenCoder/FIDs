<template>
  <div>
    <ul>
      <li v-for="year in years">
        <input
            type="checkbox"
            v-bind:value="year.year_name"
            v-model="selectedAverage"
            @change="selectAverage()"
        >
        {{year.year_name}}
      </li>
    </ul>
  </div>

</template>

<script>
  import {mapState, mapActions} from 'vuex'

  export default {
    name: "AveragePeriod",
    data() {
      return {
        selectedAverage: []
      }
    },


    mounted() {

      //this.$store.dispatch('loadYears')
    },

    computed: {
      ...mapState([
        'years'
      ]),
    },

    methods: {
      selectAverage() {

      },
    }
  }
</script>
