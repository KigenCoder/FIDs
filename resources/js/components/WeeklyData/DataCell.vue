<template>
  <td>{{thousandSeparator(weeklyPrice)}}</td>
</template>


<script>
  export default {
    name: 'data_cell',
    props: [
      'data_item_id',
      'price',
    ],

    data() {
      return {
      }
    },

    computed: {
      weeklyPrice: {
        get: function () {
          return this.price
        },
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

