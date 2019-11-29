import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user_ml: '',
        country_ml: '',
        accessToken: ''
    },
    mutations: {
        setUser(state, datosUser) {
            state.user_ml = datosUser.user_ml;
            state.country_ml = datosUser.country_ml;
            state.accessToken = datosUser.accessToken;
            console.log("store. User_ml: " + datosUser.user_ml + " Country: " + datosUser.country_ml + " AccessToken: " + datosUser.accessToken);
        },
        setTokenMl(state, accessToken) {
            state.accessToken = accessToken;
        }

    },
    actions: {
        getUserMl: async function ({ commit }) {
            if (this.state.user_ml.length === 0) {
                return await axios
                    .get("api/profile")
                    .then(response => {
                        let user_ml = response.data.user_ml;
                        let country_ml = response.data.country;
                        if (this.state.accessToken.length === 0) {
                            return axios
                                .get("api/accesstoken", { params: { ml_user: user_ml } })
                                .then(response => {
                                    let accessToken = response.data.access_token;
                                    commit('setUser', { user_ml: user_ml, country_ml: country_ml, accessToken: accessToken });
                                })
                                .catch(error => console.log(error));
                        }
                    })
                    .catch(error => console.log(error));
            }
        }
    }

});

