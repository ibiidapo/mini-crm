<template>
  <footer-component>
    <template slot="link">
      Created by <a href="https://linkedin.com/in/darkpain">Marios Vasiliou aka DarkPain</a>
    </template>
    - {{ date }}
  </footer-component>
</template>

<script>
  import FooterComponent from './FooterComponent';
  
  export default {
    name: 'AppFooter',
    components: {FooterComponent},
    computed: {
      date: function() {
        return new Date().getFullYear();
      },
    },
  };
</script>