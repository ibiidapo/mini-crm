import Lang from 'lang.js';

window.Vue.prototype.$http = window.axios;
const token = localStorage.getItem('token');
if (token) {
  window.Vue.prototype.$http.defaults.headers.common['Authorization'] = token;
}

const defaultLocale = window.default_language;
const fallbackLocale = window.fallback_locale;
const messages = window.messages;

window.Vue.prototype.$trans = new Lang({
  messages: messages,
  locale: defaultLocale,
  fallback: fallbackLocale,
});

window.Vue.prototype.$currentUser = window.user;
