<template>


    <div class="container">
        <div class="row">

        <h2>Choose the subscription plan: </h2>
        <br>
        <div v-for="plan in plans"  class="video-grid col-xs-6 col-sm-4 col-md-3">
            <div class="video">

                <div class="thumbnail">
                  <img src="http://lorempixel.com/400/200/">
                </div>

                
              

            </div>
           <button id="customButton" @click.prevent="subscribe(plan)">Purchase</button>
                   
         </div>
         <!-- <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader> -->
       <!--  <div class="sk-double-bounce" v-show="loading">
        <div class="sk-child sk-double-bounce1"></div>
        <div class="sk-child sk-double-bounce2"></div> -->


        <div class="sk-chasing-dots" v-show="loading">
        <div class="sk-child sk-dot1"></div>
        <div class="sk-child sk-dot2"></div>
      </div>

      </div>
    </div>
    
  
           
</div>

</template>

<script>
  import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    let vm = {}

    export default {
        data() {
            return {
                plans: {
                    data: [],
                    amount:''
                    
                },
                loading:false,
                color:'#0d61e8',
                size:'20px'
            }
        },

        created () {
          vm = this;
        },

        mounted() {

           

            if ( ! window.Laravel.hasOwnProperty('Auth')) {
                    this.$router.push('/');
            };

           this.$Progress.start();           
            axios.get('/api/plans').then((res) => {
                this.$Progress.finish();
                this.plans = res.data;
            }).catch((err) => {
                this.$Progress.finish();
                console.log(err);
            });

            console.log('Home Component mounted.')
        },

        methods: {

            pay(){
                

                if(! window.Laravel.hasOwnProperty('Auth')) {
                   this.$router.push('/login'); 
                   
                   this.$toasted.info('Please login to access the subscription only videos!');
                }  

            },


             subscribe(planid){
                
                vm.loading=true;
                this.$Progress.start();
               
                var handler = StripeCheckout.configure({

                  key: window.Laravel.stripekey,
                  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                  locale: 'auto',
                  email:window.Laravel.Auth.email,
                  panelLabel:'Subscribe For',
                  
               

                  token: function(token) {
                    
                   
                    axios.post('/api/charge', {
                        stripeToken: token.id,
                        plan: planid.id
                    }).then((res) => {
                      vm.loading=false;

                       vm.redirectToVideoPage();
                        
                    }).catch((err) => {
                        
                        console.log(err);
                    });

                  }


                });

                // document.getElementById('customButton').addEventListener('click', function(e) {
                  // Open Checkout with further options:


                  handler.open({
                    name: 'AutoTube',
                    description: planid.name,
                    zipCode: false,
                    amount: planid.amount
                  });
                  //e.preventDefault();

                // });


                // Close Checkout on page navigation:
                window.addEventListener('popstate', function() {
                  handler.close();

                 
                });

              this.$Progress.finish();
              

              // setTimeout(this.redirectToVideoPage,70000);
              
            },

            redirectToVideoPage(){
                this.$router.go(-1);
                this.$toasted.success('You have successfully subscribeed to our channel!');
              }

            


        }
    }
</script>

  <style type="text/css">
    /*
 *  Usage:
 *
      <div class="sk-chasing-dots">
        <div class="sk-child sk-dot1"></div>
        <div class="sk-child sk-dot2"></div>
      </div>
 *
 */
.sk-chasing-dots {
  margin: 40px auto;
  width: 40px;
  height: 40px;
  position: relative;
  text-align: center;
  -webkit-animation: sk-chasingDotsRotate 2s infinite linear;
          animation: sk-chasingDotsRotate 2s infinite linear; }
  .sk-chasing-dots .sk-child {
    width: 60%;
    height: 60%;
    display: inline-block;
    position: absolute;
    top: 0;
    background-color: #237add;
    border-radius: 100%;
    -webkit-animation: sk-chasingDotsBounce 2s infinite ease-in-out;
            animation: sk-chasingDotsBounce 2s infinite ease-in-out; }
  .sk-chasing-dots .sk-dot2 {
    top: auto;
    bottom: 0;
    -webkit-animation-delay: -1s;
            animation-delay: -1s; }
@-webkit-keyframes sk-chasingDotsRotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg); } }
@keyframes sk-chasingDotsRotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg); } }
@-webkit-keyframes sk-chasingDotsBounce {
  0%, 100% {
    -webkit-transform: scale(0);
            transform: scale(0); }
  50% {
    -webkit-transform: scale(1);
            transform: scale(1); } }
@keyframes sk-chasingDotsBounce {
  0%, 100% {
    -webkit-transform: scale(0);
            transform: scale(0); }
  50% {
    -webkit-transform: scale(1);
            transform: scale(1); } }
  </style>