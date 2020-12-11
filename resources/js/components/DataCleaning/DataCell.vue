<template>
  <div class="container">
    <input type="number" v-if="showFirstTextBox" v-model="weeklyPrice">
    <input type="text" v-if="showSecondTextBox" v-model="weeklyPrice" @focus="onFocusText">

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
      visible: true
    }
  },

  computed: {
    showFirstTextBox: {
      get: function () {
        try {
          let priceAmount = parseInt(this.marketData.price)

          if (this.type === 'indicator' && priceAmount > 0 && this.visible === false) {
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
          let priceAmount = parseInt(this.weeklyPrice)
          if (this.type === 'indicator' && priceAmount > 0 && this.visible === true) {
            return true
          } else {
            return false
          }
        } catch (error) {
          console.log("Show Second TextBox: " + error)
        }

      },
    },

    marketData:{
      get: function () {
    },
      set function (newPrice){
        this.marketData .price = newPrice
      }
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
        //console.log("Thousand separator: " + this.thousandSeparator(priceAmount))
        return this.thousandSeparator(priceAmount)

      },
      set: function (newWeeklyPrice) {
        this.weeklyPrice = newWeeklyPrice
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
      try {
        this.visible = false;
        this.weeklyPrice = parseInt(this.weeklyPrice )
        console.log("Weekly price: " + typeof this.weeklyPrice)
        console.log("MarketData.Price: " + typeof this.marketData.price)
      } catch (error) {
        console.log("On Focus Error: " + error)
      }

    },

    thousandSeparator(amount) {
      if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

      } else {
        //console.log("Else called: " + (typeof amount))
        return amount;
      }
    },


  },
}
</script>

