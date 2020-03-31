<template>
    <div>
        Login
        <label>Email</label>
        <input type="text" v-model="email">
        <label>Password</label>
        <input type="password" v-model="password">
        <button v-on:click="onSumbit">Login</button>

    </div>
</template>

<script>
export default {
    name: 'Login',
    data(){
        return {
            email:'',
            password:''
        }
    },

    methods: {
        onSumbit: function() {
            this.$emit('loginData',{email: this.email, password: this.password});
        }
    }
}
</script>