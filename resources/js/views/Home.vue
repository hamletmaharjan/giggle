<template>
    <div>
        HomePage
        <Articles></Articles>
    </div>
</template>


<script>
import Articles from '../components/Articles.vue'
export default {
    name: 'Home',
    components:{
        Articles
    }
}
</script>