<template>
  <td>
    <!-- Monthly data -->
    <input type="number" v-if="type==='indicator' && indicator_id !== 53 && column_header_id === '1' && visible ===true"
           v-model="monthlyValue"
           @blur="saveMonthlyValue">
    <input type="text" v-if="type==='indicator' && indicator_id !== 53 && column_header_id === '1' &&  visible ===false"
           v-model="monthlyValue"
           @focus="onFocusText">

    <!-- Civil Insecurity -->
    <select
        v-if="type==='indicator' && column_header_id === '1' && indicator_id === 53"
        v-model="monthlyValue" @change="saveMonthlyValue">
      <option value="" disabled selected>Select level</option>
      <option
          v-for="level in securityLevels"
          v-bind:value="level.id">
        {{ level.level }}
      </option>
    </select>

    <!-- Location -->
    <input type="text" v-if="type==='indicator' && column_header_id === '2'" v-model="location"
           @blur="saveLocation">

    <!-- Key Informant -->
    <input type="text" v-if="type==='indicator' && column_header_id === '3'" v-model="keyInformant"
           @blur="saveKeyInformant">

    <!-- Save Triangulation -->
    <input type="text" v-if="type==='indicator' && column_header_id === '4'" v-model="triangulation"
           @blur="saveTriangulation">

    <!-- Data Trust Level -->
    <select
        v-if="type==='indicator' && column_header_id === '5'" v-model="trustLevel" @change="saveTrustLevel">
      <option value="" disabled selected>Select level</option>
      <option
          v-for="trustLevel in dataTrustLevels"
          v-bind:value="trustLevel.level">
        {{ trustLevel.level }}
      </option>
    </select>


  </td>

</template>

<script>
export default {
  props: [
    'indicator_id',
    'column_header_id',
    'type',
  ],
  name: "data_entry_cell",
  data() {
    return {
      dataTrustLevels: [],
      securityLevels: [],
      monthlyValue: '',
      visible: true,
      trustLevel: '',
      keyInformant: '',
      insecurityLevel: '',
      location: '',
      triangulation: '',

    }
  },


  mounted() {
    this.dataTrustLevels = [
      {id: 1, level: "Poor"},
      {id: 2, level: "Fair"},
      {id: 3, level: "Good"},
    ]

    this.securityLevels = [
      {id: 1, level: "Tranquil"},
      {id: 2, level: "Tense but safe"},
      {id: 3, level: "Restricted Movement"},
      {id: 4, level: "Clan clashes"},
    ]

  },
  methods: {
    saveMonthlyValue: function () {
      let marketData = this.$store.getters['data_entry/getMarketData']
      let itemIndex

      let priceExists = false

      for (itemIndex in marketData) {

        let currentItem = marketData[itemIndex]

        if (currentItem.indicator_id === this.indicator_id) {
          //Item exists - So update it
          priceExists = true
          currentItem['price'] = this.monthlyValue
          this.$store.commit('data_entry/updateSlimDataMutation', currentItem)
          break
        }
      }

      if (priceExists !== true) {
        this.createPriceObject()
      }


    },

    saveLocation: function () {

      this.updatePriceObject('location_name', this.location)

    },


    saveKeyInformant: function () {

      this.updatePriceObject('key_informant', this.keyInformant)

    },

    saveTriangulation: function () {
      this.updatePriceObject('triangulation', this.triangulation)
    },

    saveTrustLevel: function () {
      this.updatePriceObject('data_trust_level', this.trustLevel)
    },


    onFocusText() {
      this.visible = true;

      this.monthlyValue = this.temp;
    },

    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      } else {
        return amount;
      }
    },

    createPriceObject() {
      let year_name = this.$store.getters['data_entry/getYearName']
      let month_id = this.$store.getters['data_entry/getMonthId']
      let market_id = this.$store.getters['data_entry/getMarketId']
      let indicator_id = this.indicator_id


      if (market_id && year_name && month_id && indicator_id
          && this.monthlyValue !== '' && this.monthlyValue !== null) {
        let priceObject = {
          market_id: market_id,
          year_name: year_name,
          month_id: month_id,
          week_id: 1,
          indicator_id: indicator_id,
          price: this.monthlyValue,
          supply_id: 4, //Default to normal,
          location_name: this.location,
          key_informant: this.keyInformant,
          triangulation: this.triangulation,
          data_trust_level: this.trustLevel,
        }
        this.$store.commit('data_entry/updateSlimDataMutation', priceObject)
      }
    },


    updatePriceObject(key, value) {
      let marketData = this.$store.getters['data_entry/getMarketData']
      let itemIndex

      for (itemIndex in marketData) {

        let currentItem = marketData[itemIndex]

        if (currentItem.indicator_id === this.indicator_id) {
          currentItem[key] = value
          this.$store.commit('data_entry/updateSlimDataMutation', currentItem)
        }
      }

    }

  },
}
</script>
