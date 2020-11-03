<template>
  <div class="container">

    <input type="number" v-if="showFirstTextBox" v-model="weeklyPrice" @blur="updatePrice">

  </div>
</template>


<script>
export default {
  name: 'data_cell',
  props: [
    'dataSet',
    'type',
    'currentIndex',
  ],

  data() {
    return {
      newPrice: '',
      marketData: {},
    }
  },

  computed: {
    showFirstTextBox: {
      get: function () {
        try {
          if (this.type === 'indicator' && this.weeklyPrice > 0) {
            return true
          } else {
            return false
          }
        } catch (error) {
          console.log("Show First TextBox: " + error)
        }
      },
    },

    showSecondTextBox: {
      get: function () {
        try {
          if (this.type === 'indicator' && this.weeklyPrice > 0) {
            return true
          } else {
            return false
          }
        } catch (error) {
          console.log("Show First TextBox: " + error)
        }

      },
    },


    weeklyPrice: {
      get: function () {
        let priceObject
        let priceAmount = ""
        for (priceObject of this.dataSet) {
          try {
            let week = parseInt(priceObject.week)
            let price = parseInt(priceObject.price)

            if (week === this.currentIndex && price > 0) {
              this.marketData = {
                "price_id": priceObject.id,
                "price": price,
              }
              priceAmount = price
            }
          } catch (error) {
            console.log(error)
          }
        }
        return priceAmount

      },
      set: function (newWeeklyPrice) {
        this.marketData.price = newWeeklyPrice
      }
    }
  },

  mounted() {

  },

  methods: {
    updatePrice: function () {
      this.$store.commit('data_cleaning/marketUpdatesMutation', this.marketData)
    },

    onFocusText() {
      this.visible = true;
      this.weeklyPrice = this.temp;
    },

    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      } else {
        return amount;
      }
    },


  },
}
</script>

