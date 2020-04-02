<template>
    <div>
        <AppHeader></AppHeader>
        <div>
            <router-view></router-view>
        </div>
    </div>
    
</template>


<script>
import axios from 'axios';
import AppHeader from './components/AppHeader.vue';
export default {
    name: 'App',
    data() {
        return {
            token:''
        }
    },
    components: {
        AppHeader,
        Login
    },
    methods: {
        login: function(loginData){
            // axios.post('https://www.googleapis.com/youtube/v3/search',{
            //     headers:{
            //         'Content-Type': 'application/json',
            //         'X-Requested-With': 'XMLHttpRequest'
            //     },
            //     body: {
            //         email: loginData.email,
            //         password: loginData.password
            //     }
            // }).then(response => {
            //     console.log(response);
            // });

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/json");
            myHeaders.append("X-Requested-With", "XMLHttpRequest");

            var raw = JSON.stringify({"email":loginData.email,"password":loginData.password});

            var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
            };

            fetch("http://localhost:8000/api/auth/login", requestOptions)
            .then(response => response.text())
            .then(result => {
                
                var data = JSON.parse(result);
                console.log(data);
                this.token = data.access_token;
            })
            .catch(error => console.log('error', error));

        }
    }
}
</script>


