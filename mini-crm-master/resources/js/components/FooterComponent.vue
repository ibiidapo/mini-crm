<template>
  <footer :class="classes">
    <div class="container">
      <span
        :class="color"
      >
        <slot
          name="link"
          v-html="prop"
        ></slot>
        <slot>Copyright</slot>
      </span>
    </div>
  </footer>
</template>

<script>
  export default {
    name: 'FooterComponent',
    props: {
      label: {
        type: String,
        required: false,
      },
      classes: {
        type: String,
        required: false,
        default: 'footer bg-dark',
      },
      color: {
        type: String,
        required: false,
        default: 'text-white',
      },
    },
  };
</script>