import { get, store, remove } from "@/api/giftBgImg";

const state = {
  bgImgs: []
};

const mutations = {
  GET_BGIMGS: (state, bgImgs) => {
    state.bgImgs = bgImgs;
  },
  CLEAR_BGIMGS: state => {
    state.bgImgs = [];
  },
  ADD_BGIMG: (state, bgImg) => {
    state.bgImgs = [...state.bgImgs, bgImg];
  },
  REMOVE_BGIMG: (state, deletedLogo) => {
    var filteredLogos = state.bgImgs.filter(bgImg => {
      if (bgImg.id != deletedLogo.id) return true;
      return false;
    });
    state.bgImgs = [...filteredLogos];
  }
};

const actions = {
  store({ commit }, bgImg) {
    console.log("giftLogo store", bgImg);
    return new Promise((resolve, reject) => {
      store(bgImg)
        .then(response => {
          const data = response;
          commit("ADD_BGIMG", data);
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
          console.log("get bgImgs", data);
          commit("GET_BGIMGS", data.bgImgs);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  remove({ commit }, bgImg) {
    return new Promise((resolve, reject) => {
      remove(bgImg)
        .then(response => {
          commit("REMOVE_BGIMG", bgImg);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
