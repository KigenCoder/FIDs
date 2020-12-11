<template>
  <tr v-bind:class="list_item.type">
    <!-- Category/Indicator name -->
    <td>{{list_item.name}}</td>
    <slims_cell v-for="header in column_headers"
               v-bind:key="header.id"
               v-bind:indicator_id="list_item.id"
               v-bind:column_header_id="header.id"
               v-bind:type="list_item.type">
    </slims_cell>
  </tr>
</template>


<script>

  import slims_cell from "./SlimsEntryCell.vue"

  export default {
    name: 'indicator_list_item',
    props: ['list_item'],
    components: {
      slims_cell,
    },

    data() {
      return {
        column_headers: [],
      }
    },

    computed: {
    },

    mounted() {
      this.column_headers = [
        {id: "1", "title": "Monthly"},
        {id: "2", "title": "Location"},
        {id: "3", "title": "Key Informant"},
        {id: "4", "title": "Triangulation"},
        {id: "5", "title": "Data Trust Level"},

      ]
    },

    methods: {},
  }
</script>

