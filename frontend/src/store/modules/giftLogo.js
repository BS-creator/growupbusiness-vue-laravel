import { get, store, remove } from "@/api/giftLogo";

const state = {
  logoImgs: []
};

const mutations = {
  GET_LOGOS: (state, logos) => {
    state.logoImgs = logos;
  },
  CLEAR_LOGOS: state => {
    state.logoImgs = [];
  },
  ADD_LOGO: (state, logo) => {
    state.logoImgs = [...state.logoImgs, logo];
  },
  REMOVE_LOGO: (state, deletedLogo) => {
    var filteredLogos = state.logoImgs.filter(logo => {
      if (logo.id != deletedLogo.id) return true;
      return false;
    });
    state.logoImgs = [...filteredLogos];
  }
};

const actions = {
  store({ commit }, logo) {
    console.log("giftLogo store", logo);
    return new Promise((resolve, reject) => {
      store(logo)
        .then(response => {
          const data = response;
          commit("ADD_LOGO", data);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  get({ commit }) {
    return new Promise((resolve, reject) => {
      get()
        .then(response => {
          const data = response;
          commit("GET_LOGOS", data.logos);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  remove({ commit }, logo) {
    return new Promise((resolve, reject) => {
      remove(logo)
        .then(response => {
          commit("REMOVE_LOGO", logo);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  clearLogos({ commit }) {
    commit("CLEAR_LOGOS");
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
