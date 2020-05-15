import Vue from "vue";
import VueAxios from "vue-axios";
import VueSocialauth from "vue-social-auth";
import axios from "axios";

import Cookies from "js-cookie";

import "normalize.css/normalize.css"; // a modern alternative to CSS resets

import Element from "element-ui";
import "./styles/element-variables.scss";
import enLang from "element-ui/lib/locale/lang/en";

import "@/styles/index.scss"; // global css

import App from "./App";
import store from "./store";
import router from "./router";

import "./icons"; // icon
import "./permission"; // permission control
import "./utils/error-log"; // error log

import * as filters from "./filters"; // global filters

/**
 * If you don't want to use mock-server
 * you want to use MockJs for mock api
 * you can execute: mockXHR()
 *
 * Currently MockJs will be used in the production environment,
 * please remove it before going online ! ! !
 */
if (process.env.NODE_ENV === "production") {
  const { mockXHR } = require("../mock");
  mockXHR();
}

Vue.use(Element, {
  size: Cookies.get("size") || "medium", // set element-ui default size
  locale: enLang
});

Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {
  providers: {
    google: {
      clientId:
        "371557585368-kr7esehrm7tnpjj8ar33l7th61t8dh8j.apps.googleusercontent.com",
      redirectUri: "http://localhost:9527/" // Your client app URL
    },
    facebook: {
      clientId: "3377665655627904"
    },
    instagram: {
      clientId: "3377665655627904"
    }
  }
});
const ServerURL = "http://localhost:8000/api/";
Vue.prototype.$ServerURL = ServerURL;
// register global utility filters
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

Vue.config.productionTip = false;

new Vue({
  el: "#app",
  router,
  store,
  render: h => h(App)
});
