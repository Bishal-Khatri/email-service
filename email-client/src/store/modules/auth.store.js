import AuthService from "../../services/AuthService";
import router from '@/router'

export const AuthStore = {
    namespaced: true,
    // strict: true,
    state () {
        return {
            user: null,
        }
    },
    mutations:{
        setUser(state, user){
            state.user = user
        },
        setUserToken(state, token){
            state.token = token
        },
        LogOut(state){
            state.user = null;
            state.token = null;
        },
    },
    getters:{
        isAuthenticated: state => !! state.token,
        StateUser: state => state.user,
    },
    actions:{
        async LogOut({commit}){
            await commit('LogOut');
        },
        async Register({commit}, User) {
            const response = await AuthService.register(User);
            if (response.data.error === false){
                await commit('setUser', response.data.data.user);
                await commit('setUserToken', response.data.data.token);
                router.push("/inbox");
            }else{
                router.push("/register");
            }
        },
        async LogIn({commit}, User) {
            const response = await AuthService.login(User);
            if (response.data.error === false) {
                await commit('setUser', response.data.data.user);
                await commit('setUserToken', response.data.data.token);
                router.push("/inbox");
            }else{
                router.push("/login");
            }
        },
    }
};
