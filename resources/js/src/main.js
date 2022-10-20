import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'
import { Can,abilitiesPlugin } from '@casl/vue';
import {ability} from './ability.js'

import Loading from 'vue-slim-loading'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(Loading)
Vue.use(VueToast)
Vue.config.productionTip = false


new Vue({
  router,
  store,
  vuetify,
  abilitiesPlugin,
  render: h => h(App)
}).$mount('#app');

Vue.use(abilitiesPlugin, ability,{
  useGlobalProperties: true
}).component(Can.name, Can);