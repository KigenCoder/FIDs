<template>
  <div>{{thousandSeparator(weeklyPrice)}}</div>
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
      return {}
    },

    computed: {
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

        }
      }
    },
    methods: {
      thousandSeparator(amount) {
        if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
          return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        } else {
          return amount;
        }
      }
    },

  }
</script>

