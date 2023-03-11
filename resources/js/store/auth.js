
import {routes} from '../routes.js'
import axios from 'axios';

const user = localStorage.getItem('user');

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        token: null,
    },
    getters:{
        isAuthenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        },
        token(state){
            return state.token
        },
  
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
           SET_TOKEN (state, value) {
            state.token = value
        },
        refreshToken(state, accessToken) {
            state.authenticated = true;
            state.user = { ...state.user, accessToken: accessToken };
          }
    },
    actions:{
        refreshToken({ commit }, accessToken) {
            commit('refreshToken', accessToken);
          },
        login({commit},data){
            console.log(data)
           
                commit('SET_USER',data.user)
                commit('SET_TOKEN','Bearer '+data.token)
                commit('SET_AUTHENTICATED',true)
                localStorage.setItem('token', 'Bearer '+data.token)
                localStorage.setItem('user',data.user)
                localStorage.setItem('auth',true)
                axios.defaults.headers.common['Authorization'] = 'Bearer '+data.token
                
        },
        logout({commit}){
            commit('SET_USER',{})
            commit('SET_TOKEN',null)
            commit('SET_AUTHENTICATED',false)
            localStorage.removeItem('token')
            localStorage.removeItem('auth')
            localStorage.removeItem('user')
        },
        async handleResponse({commit},response) {
             
                    if (response.status === 401) {
               
                      
                     commit('SET_USER',{})
                     commit('SET_TOKEN',null)
                     commit('SET_AUTHENTICATED',false)
                     localStorage.removeItem('token')
                     localStorage.removeItem('auth')
                     localStorage.removeItem('user')
                        
                    }
     
        }
    }
}