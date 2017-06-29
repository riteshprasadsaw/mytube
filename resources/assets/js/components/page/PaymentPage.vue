<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payment Page
                    </div>
               
                    <div class="panel-footer text-left">
                              <button id="customButton" @click="subscribe()">Purchase</button>

                            </div>
                </div>

                
            </div>
        </div>
    </div>
</template>

<script>

     
    
    export default {
        props: ['id'],
        data() {
            return {
                
                plan: {},
                isSubscribed:'',
                token:''               
                             
            }
        },
        mounted() {

                if ( ! window.Laravel.hasOwnProperty('Auth')) {
                this.$router.push('/');
                };

                this.$Progress.start();
             

                
               console.log('Component mounted.');
               this.$Progress.finish();
        },

        methods: {
           

            subscribe(){
                var handler = StripeCheckout.configure({
                  key: 'pk_test_6pRNASCoBOKtIshFeQd4XMUh',
                  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                  locale: 'auto',
                  token: function(token) {
                    
                   
                    axios.post('/api/charge/'+this.id,this.token).then((res) => {
                    this.$router.go(-1); 
                    }).catch((err) => {
                        
                        console.log(err);
                    });

                  }
                });

                document.getElementById('customButton').addEventListener('click', function(e) {
                  // Open Checkout with further options:
                  handler.open({
                    name: 'Stripe.com',
                    description: '2 widgets',
                    zipCode: true,
                    amount: 2000
                  });
                  e.preventDefault();
                });

                // Close Checkout on page navigation:
                window.addEventListener('popstate', function() {
                  handler.close();
                });

                // axios.post('/api/charge',this.data).then((res) => {
                    
                //     }).catch((err) => {
                        
                //         console.log(err);
                // });
            }


         
        }


    }
</script>
