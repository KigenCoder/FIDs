<template>
  <div class="container">
    <input type="number" v-if="type==='indicator' && this.weeklyPrice >0 " v-model="weeklyPrice" @blur="updatePrice">
    <!-- <input type="text" v-if="showSecondTextBox" v-model="weeklyPrice" @focus="onFocusText"> -->

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
      dataObject: {},
      visible: true,
    }
  },

  computed: {



    // showFirstTextBox: {
    //   get: function () {
    //     try {
    //       let priceAmount = parseInt(this.dataObject.price)
    //
    //       if (this.type === 'indicator' && priceAmount > 0 && this.visible === false) {
    //         return true
    //       } else {
    //         return false
    //       }
    //     } catch (error) {
    //       console.log("Show First TextBox: " + error)
    //     }
    //   },
    // },
    //
    // showSecondTextBox: {
    //   get: function () {
    //     try {
    //       let priceAmount = parseInt(this.weeklyPrice)
    //       if (this.type === 'indicator' && priceAmount > 0 && this.visible === true) {
    //         return true
    //       } else {
    //         return false
    //       }
    //     } catch (error) {
    //       console.log("Show Second TextBox: " + error)
    //     }
    //
    //   },
    // },


    weeklyPrice: {
      get: function () {
        let priceObject
        let priceAmount = ""
        for (priceObject of this.dataSet) {
          try {
            let week = parseInt(priceObject.week)
            let price = parseInt(priceObject.price)

            if (week === this.currentIndex && price > 0) {
              this.dataObject = {
                "price_id": priceObject.id,
                "price": price,
              }
              priceAmount = price
            }
          } catch (error) {
            //console.log(error)
          }
        }
        return priceAmount

      },
      set: function (newWeeklyPrice) {
        this.dataObject.price = newWeeklyPrice
      }
    },

  },

  mounted() {

  },

  methods: {
    updatePrice: function () {
      try {
        let dataObjectPrice = parseInt(this.dataObject.price)
        let vModelPrice = parseInt(this.weeklyPrice)

        if (dataObjectPrice !== vModelPrice) {
          //Update price
          this.$store.commit('data_cleaning/marketUpdatesMutation', this.dataObject)
        }

      } catch (e) {
        console.log("Exception: ", e)
      }


    },


    onFocusText() {
      try {
        this.visible = false;
        this.weeklyPrice = parseInt(this.weeklyPrice)
        //console.log("Weekly price: " + typeof this.weeklyPrice)
        //console.log("MarketData.Price: " + typeof this.dataObject.price)
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

