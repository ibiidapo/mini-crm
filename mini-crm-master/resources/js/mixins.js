import route from '../../vendor/tightenco/ziggy/src/js/route';

window.Vue.mixin({
  methods: {
    route: route,
    trans: function(key, replacements) {
      return this.$trans.get(key, replacements);
    },
  },
});