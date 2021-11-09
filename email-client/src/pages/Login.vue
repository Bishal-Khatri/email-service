<template>
    <div class="login">
        <div class="generator">
            <div class="header">
                <h2>Login</h2>
            </div>
            <div class="form">
                <form class=pwgen-form @submit.prevent="login">
                    <input type="email" v-model="email" placeholder="Email">
                    <input type="password" v-model="password" placeholder="Password">
                    <button type="submit">Login</button>
                </form>
                Don't have an account? <router-link to="/register">Register</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    // import "@/assets/css/login.css";
    import {mapActions} from "vuex";

    export default {
        name: "Login",
        data() {
            return {
                email: "",
                password: "",
                showError: false
            };
        },
        methods: {
            ...mapActions('auth',['LogIn']),
            async login() {
                const User = {
                    email: this.email,
                    password: this.password
                };
                try {
                    await this.LogIn(User);
                    this.showError = false
                } catch (error) {
                    this.showError = true
                }
            },
        },
    }
</script>

<style scoped>
    @import '../assets/css/login.css';
</style>
