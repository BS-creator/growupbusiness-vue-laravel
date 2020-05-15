import {
  login,
  signup,
  socialSignup,
  socialSignin,
  logout,
  getInfo
} from "@/api/user";
import { getToken, setToken, removeToken } from "@/utils/auth";
import router, { resetRouter } from "@/router";

const state = {
  token: getToken(),
  name: "",
  avatar: "",
  introduction: "",
  roles: []
};

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token;
  },
  SET_INTRODUCTION: (state, introduction) => {
    state.introduction = introduction;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  }
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { email, password } = userInfo;
    return new Promise((resolve, reject) => {
      login({ email: email, password: password })
        .then(response => {
          const data = response;
          commit("SET_TOKEN", data.api_token);
          setToken(data.api_token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user social login
  socialSignin({ commit }, data) {
    const { provider, response } = data;
    return new Promise((resolve, reject) => {
      socialSignin(data)
        .then(response => {
          commit("SET_TOKEN", response.api_token);
          setToken(response.api_token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user signup
  signup({ commit }, userInfo) {
    const { email, password, username } = userInfo;
    return new Promise((resolve, reject) => {
      signup({ name: username, email: email, password: password })
        .then(response => {
          console.log("store sign", response);
          commit("SET_TOKEN", response.api_token);
          setToken(response.api_token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user social signup
  socialSignup({ commit }, data) {
    const { provider, response } = data;
    return new Promise((resolve, reject) => {
      socialSignup(data)
        .then(response => {
          commit("SET_TOKEN", response.api_token);
          setToken(response.api_token);
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.token)
        .then(response => {
          console.log("getInfo", response);
          const data = response;
          data.roles = [data.role];
          if (!data) {
            reject("Verification failed, please Login again.");
          }

          const { roles, name, avatar, introduction } = data;

          // roles must be a non-empty array
          if (!roles || roles.length <= 0) {
            reject("getInfo: roles must be a non-null array!");
          }
          commit("SET_ROLES", roles);
          commit("SET_NAME", name);
          commit("SET_AVATAR", avatar == null ? "/nouser.png" : avatar);
          commit("SET_INTRODUCTION", introduction);
          resolve(data);
        })
        .catch(error => {
          console.log("getinfo error", error);
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit, state, dispatch }) {
    return new Promise((resolve, reject) => {
      logout(state.token)
        .then(() => {
          commit("SET_TOKEN", "");
          commit("SET_ROLES", []);
          removeToken();
          resetRouter();

          // reset visited views and cached views
          // to fixed https://github.com/PanJiaChen/vue-element-admin/issues/2485
          dispatch("tagsView/delAllViews", null, { root: true });

          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit("SET_TOKEN", "");
      commit("SET_ROLES", []);
      removeToken();
      resolve();
    });
  },

  // dynamically modify permissions
  changeRoles({ commit, dispatch }, role) {
    return new Promise(async resolve => {
      const token = role + "-token";

      commit("SET_TOKEN", token);
      setToken(token);

      const { roles } = await dispatch("getInfo");

      resetRouter();

      // generate accessible routes map based on roles
      const accessRoutes = await dispatch("permission/generateRoutes", roles, {
        root: true
      });

      // dynamically add accessible routes
      router.addRoutes(accessRoutes);

      // reset visited views and cached views
      dispatch("tagsView/delAllViews", null, { root: true });

      resolve();
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
