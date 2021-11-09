import Api from './Api';

export default {
    login(formData){
        return Api().post('login',formData);
    },

    register(formData){
        return Api().post('register',formData);
    },
}
