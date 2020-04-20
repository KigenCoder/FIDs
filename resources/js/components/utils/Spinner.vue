<template>
  <div v-if="isLoading" class="modal" :class="isActive">
    <div class="modal-background"></div>
    <div class="modal-content">
      <tile :loading="isLoading"
            :height="height"
            :width="width"
      >

      </tile>
    </div>
  </div>
</template>

<script>
  export default {
    name: "spinner",
    data() {
      return {
        isLoading: false,
        isActive: '',
        height: '400',
        width: '400',
      }
    },

    mounted() {
      this.$store.subscribe((mutation, state) => {
        if (mutation.type === 'utils/loadingStateMutation') {
          this.isLoading = state.utils.loading
          //console.log("Show spinner: ", this.isLoading)
          if (this.isLoading) {
            this.isActive = 'is-active'
          } else {
            this.isActive = ''
          }
        }
      })
    },
    methods: {},
  }
</script>
