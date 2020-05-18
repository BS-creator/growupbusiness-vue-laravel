import { get, getOne, update, store, remove } from "@/api/giftCard";

const state = {
  giftCards: [],
  activeCard: null
};

const mutations = {
  GET_CARDS: (state, cards) => {
    state.giftCards = cards;
  },
  UPDATE_CARDS: (state, updatedCard) => {
    var targetCard = state.giftCards.find(card => {
      if (card.id == updatedCard.id) return true;
      return false;
    });
    targetCard = updatedCard;
    state.giftCards = [...state.giftCards];
  },
  ADD_CARD: (state, card) => {
    state.giftCards = [...state.giftCards, card];
  },
  REMOVE_CARD: (state, deletedCard) => {
    var filteredCards = state.giftCards.filter(card => {
      if (card.id != deletedCard.id) return true;
      return false;
    });
    state.giftCards = [...filteredCards];
  },
  SET_ACTIVE_CARD: (state, card) => {
    state.activeCard = card;
  }
};

const actions = {
  store({ commit }, card) {
    console.log("giftCard store", card);
    return new Promise((resolve, reject) => {
      store(card)
        .then(response => {
          const card = response.card;
          commit("ADD_CARD", card);
          commit("SET_ACTIVE_CARD", card);
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
          commit("GET_CARDS", []);
          commit("GET_CARDS", data.cards);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  update({ commit }, cardId) {
    return new Promise((resolve, reject) => {
      update(cardId)
        .then(response => {
          const data = response;
          commit("UPDATE_CARDS", data.card);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  getOne({ commit }, cardId) {
    return new Promise((resolve, reject) => {
      getOne(cardId)
        .then(response => {
          const data = response;
          commit("UPDATE_CARDS", data.card);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  remove({ commit }, card) {
    return new Promise((resolve, reject) => {
      remove(card)
        .then(() => {
          commit("REMOVE_CARD", card);
          resolve();
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  setActiveCard({ commit }, card) {
    commit("SET_ACTIVE_CARD", card);
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
