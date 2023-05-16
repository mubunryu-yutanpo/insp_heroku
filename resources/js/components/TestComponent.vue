<template>
    <h1>てすとこんぽ</h1>
</template>
  
<script>
    import axios from 'axios';

    export default {
    mounted() {
        axios.get('/api/test')
        .then(response => {
            console.log('apiOK');
            console.log('れすぽんす' + response.data.message);
        })
        .catch(error => {
            console.log(error);
        });
    },
    };
</script>
  