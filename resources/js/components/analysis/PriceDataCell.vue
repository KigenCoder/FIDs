<template>
  <td>{{currentPrice}}</td>
</template>



<script>
  export default {
    name: 'data-cell',
    props: ['data'],

    data() {
      return {}
    },

    computed: {
      currentPrice: function () {
        return this.data.price
      }
    },
  }
</script>

