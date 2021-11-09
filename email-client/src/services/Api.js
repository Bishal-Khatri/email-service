import axios from 'axios'
import router from "../router";

export default () => {
    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
    axios.interceptors.response.use(undefined, function (error) {
        if (error) {
            const originalRequest = error.config;
            if (error.response.status === 401 && !originalRequest._retry) {

                originalRequest._retry = true;
                // store.dispatch('LogOut')
                return router.push('/login')
            }
        }
    })
    return axios.create();
}
