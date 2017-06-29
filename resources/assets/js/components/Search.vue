<template>
   
         <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input name="q" type="search" class="form-control" placeholder="Search" v-model="query" @keyup.enter="searchVideo()">
                        </div>
                        <button  type="submit" class="btn btn-default btn-search" @click.prevent="searchVideo()">
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
                loading: false,
                error: false,
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
                     // Clear the error message.

                    if(!this.query){
                      this.$router.push('/');
                      return;
                    }
                    this.error = '';
                    // Empty the products array so we can fill it with the new products.
                    // this.products = [];
                    // Set the loading property to true, this will display the "Searching..." button.
                    this.loading = true;

                    axios.get('/api/search?q=' + this.query).then((res) => {
                   
                    this.videos = res.data;
                      // console.log(this.videos);
                      this.$eventBus.$emit('searchVideo', this.videos);
                      }).catch((err) => {
                          this.$Progress.finish();
                          console.log(err);
                      });
                  
                     this.loading = false;
                      // Clear the query.
                      this.query = '';

                    // this.$eventBus.$emit('searchVideo', this.videos);
                    this.$Progress.finish();
                    
                    
                    
                    this.$router.push('/searchresults')
            },

            
            
       } 
    }
</script>