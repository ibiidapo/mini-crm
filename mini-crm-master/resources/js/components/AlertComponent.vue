<template>
  <b-alert
    ref="alert"
    :show="dismissCountDown"
    :variant="variant"
    @dismissed="dismissCountDown=0"
    dismisable
    fade
    @dismiss-count-down="countDownChanged"
  >
    {{ message }}
  </b-alert>
</template>

<script>
  export default {
    name: 'AlertComponent',
    props: {
      message: {
        type: String,
        required: true,
      },
      variant: {
        type: String,
        required: false,
        default: 'success',
      },
      dismissSecs: {
        type: Number,
        required: false,
        default: 5,
      },
    },
    data() {
      return {
        dismissCountDown: 0,
      };
    },
    methods: {
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown;
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs;
      },
    },
  };
</script>
