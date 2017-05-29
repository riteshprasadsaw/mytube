<template>
   
      <div class="panel panel-default">
                        <div class="panel-heading">
                            Search Results for :
                        </div>

                        <div class="panel-body" >
                            <video-thumb :list="results.data"></video-thumb>
                           
                        </div>
     </div>
                 
    
</template>

<script>
    
    export default {
        
        props: ['videos'],

        data() {
            return {
               
                results:[]
               
            }
        },

        created() {
             this.$eventBus.$on('searchVideo', this.onReceive);
            
        },
        mounted() {
             console.log('Search Results page mounted');
             // bus.$on('searchVideo', function (videos) {
             //    console.log(this.videos);
             //    alert('seacrh oage');
             // })
        },

       methods:{

        onReceive(videos) {
            
            // alert('searrh'+videos);
            // console.log(text);
            this.results=videos;
            console.log(this.results);
        }
                 
       } 
    }
</script>