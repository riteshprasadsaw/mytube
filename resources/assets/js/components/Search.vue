<template>
   
         <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input name="q" type="search" class="form-control" placeholder="Search" v-model="query" @keyup.enter="searchVideo()">
                        </div>
                        <button  type="submit" class="btn btn-default btn-search" @click="searchVideo()">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
          </form> 


    
</template>

<script>

   
    var algoliasearch=require('algoliasearch')
    var client = algoliasearch('AOBRMTMOCF', '150920100689c0f974e49902e69f4510')
    var index = client.initIndex('videos')

    export default {

        data() {
            return {
                query:'',
                videos: {
                    data: []
                },
                results:[]
               
            }
        },

        mounted() {

               // index.search('Ut sint sint sequi quidem', function(err, content) {
               //    console.log(err,content);
               //    console.log('search component mounted');
               //  })
             
        },

       methods:{
         searchVideo() {
                    this.$Progress.start();
                    // index.search(this.query, function(err, content) {
                    // this.videos=content.hits;
                    
                    //  })

                    axios.get('/api/videos').then((res) => {
                   
                    this.videos = res.data;
                      // console.log(this.videos);
                      this.$eventBus.$emit('searchVideo', this.videos);
                      }).catch((err) => {
                          this.$Progress.finish();
                          console.log(err);
                      });
                  
                   

                    // this.$eventBus.$emit('searchVideo', this.videos);
                    this.$Progress.finish();
                    
                    
                    
                    this.$router.push('/searchresults')
            },

            
            
       } 
    }
</script>