<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Payment Page
                    </div>
               
                    <div class="panel-footer text-left">
                                <form id="payment-form" @submit.prevent="subscribe()" method="post" action="">
                                   

                                    <h3 class="text-center">
                                        <span class="payment-errors label label-danger"></span>
                                    </h3>

                                    <div class="form-row">
                                        <div class='col-xs-12 form-group card required'>
                                                <label class='control-label'>Card Number</label>
                                                <input autocomplete='off' value="4242 4242 4242 4242" class='form-control card-number' data-stripe="number" size='20' type='text' required>
                                            </div>
                                    </div>

                                    <div class='form-row'>
                                        <div class='col-xs-4 form-group cvc required'>
                                                <label class='control-label'>CVC</label>
                                                <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' data-stripe="cvc" size='4' type='text' required>
                                            </div>
                                        <div class='col-xs-4 form-group expiration required'>
                                                <label class='control-label'>Expiration Month</label>
                                                <input class='form-control card-expiry-month' placeholder='MM' value="" data-stripe="exp_month" size='2' type='text' required>
                                        </div>

                                        <div class='col-xs-4 form-group expiration required'>
                                                <label class='control-label'> Year</label>
                                                <input class='form-control card-expiry-year' placeholder='YY' data-stripe="exp_year" size='2'  value="" type='text' required>
                                            </div>
                                    </div>

                                    <div class="form-row">
                                            <div class="col-md-4">
                                                <div class='form-group cvc required'>
                                                    <label class='control-label'>Coupon Code</label>
                                                    <input autocomplete='off' class='form-control' placeholder='Coupon code' name="coupon" type='text'>
                                                </div>
                                            </div>
                                        </div>

                                    <input type="hidden" name="plan" :value="plan.id">
                                    <input type="submit" class="submit btn btn-success btn-lg btn-block" value="Make $9 Payment">
                                </form>
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

                
            }
        },
        mounted() {
            this.$Progress.start();

                axios.get('/api/plans/'+this.id).then((res) => {
                    this.$Progress.finish();
                    this.plan=res.data;
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                
            console.log('Component mounted.')
        },

        methods: {
           

            subscribe(){
                this.$Progress.start();

                axios.post('/api/plans').then((res) => {
                    this.$Progress.finish();
                    
                    
                    alert("Payment is done");
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                console.log('Home Component mounted.')
            }
        }


    }
</script>
