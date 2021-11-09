<template>
    <div class="login">
        <div class="generator">
            <div class="header">
                <h2>Register</h2>
            </div>
            <div class="form">
                <form class=pwgen-form @submit.prevent="register" method="post">
                    <input type="text" v-model="name" placeholder="Full Name">
                    <input type="email" v-model="email" placeholder="Email">
                    <input type="password" v-model="password" placeholder="Password">
                    <input type="password" v-model="confirm_password" placeholder="Confirm Password">
                    <button type="submit">Register</button>
                </form>
                Already have an account? <router-link to="/login">Login</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    // import "@/assets/css/login.css";
    import {mapActions} from "vuex";
    export default {
        name: "Register",
        data(){
            return{
                name: '',
                email: '',
                password:'',
                confirm_password:'',
            }
        },
        methods:{
            ...mapActions('auth',['Register']),
            async register(){
                const User = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.confirm_password,
                };
                try {
                    await this.Register(User);
                    this.showError = false
                } catch (error) {
                    this.showError = true
                }
            }
        }
    }
</script>

<style scoped>
    /*@import '../assets/css/login.css';*/
</style>
