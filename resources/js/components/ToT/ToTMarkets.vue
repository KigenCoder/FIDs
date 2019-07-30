<template>
  <div v-if="marketsPopulated" class="field control">
    <p>
      <strong>Markets</strong>
    </p>
    <ul>
      <li>
        <input type="checkbox" @click="selectAll" v-model="allSelected"> All
      </li>
      <li v-for="market in markets ">
        <label class="checkbox">
          <input
              type="checkbox"
              v-bind:value="market.id"
              v-model="marketIds"
              @change="select"
          >
          {{market.market_name}}
        </label>
      </li>
    </ul>
  </div>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "markets",
    data() {
      return {
        allSelected: false,
        marketIds: [],
        marketsPopulated: false,
      }
    },

    computed: {
      ...mapState('monthly_analysis', [
        'markets'
      ])
    },
    mounted() {
      this.$store.subscribe((mutation, state) => {
        switch (mutation.type) {
          case 'monthly_analysis/marketsMutation':
            if (this.markets.length > 0) {
              this.marketsPopulated = true
            }
        }
      })

    },

    methods: {
      selectAll: function () {
        this.marketIds = []
        this.allSelected = !this.allSelected
        if (this.allSelected) {

          this.markets.forEach(market => {
            this.marketIds.push(market.id)
          })


          this.getData()
        }


      },

      select: function () {
        this.allSelected = false
        this.getData()
      },


      getData: function () {

        if (this.marketIds.length > 0) {


          //Update markets store Ids
          let marketIds = this.marketIds.toString()

          //console.log(marketIds)


          //Commit market Ids mutation
          this.$store.commit('monthly_analysis/totMarketIdsMutation', marketIds)

          //If Indicator, start & end year are set get data
          let startYear = this.$store.getters['monthly_analysis/getToTStartYear']
          let endYear = this.$store.getters['monthly_analysis/getToTEndYear']
          let firstIndicatorId = this.$store.getters['monthly_analysis/getToTFirstIndicator']
          let secondIndicatorId = this.$store.getters['monthly_analysis/getToTSecondIndicator']

          if (startYear && endYear && firstIndicatorId && secondIndicatorId) {
            //load data if indicator, start and end year determined
            this.$store.dispatch('monthly_analysis/loadToTData')
            this.$store.dispatch('monthly_analysis/loadToTMetaData')
          }

        } else {
          //Reset stuff
          this.$store.commit('monthly_analysis/totMarketIdsMutation', null)
          this.$store.commit('monthly_analysis/totAnalysisDataMutation', [])
          this.$store.commit('monthly_analysis/totMetaDataMutation', [])
        }
      },

    },


  }
</script>

