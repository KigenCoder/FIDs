<template>
  <td>{{weeklyPrice}}</td>
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
  }
</script>

