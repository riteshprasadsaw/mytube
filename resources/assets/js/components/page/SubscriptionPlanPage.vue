<template>
    <div class="container">
        <div class="row">

        <h2>Choose the subscription plan: </h2>
        <br>
        <div v-for="plan in plans"  class="video-grid col-xs-6 col-sm-4 col-md-3">
            <div class="video">

                <div class="thumbnail">
                    <router-link :to="{ name: 'PaymentPage',params: {id: id}}">
                        <img src="http://lorempixel.com/400/200/">

                    </router-link>
                  
                </div>
                
                <router-link :to="{ name: 'PaymentPage',params: {id: plan.id}}">
                <button class="btn btn-primary btn-lg">{{plan.name}}</button>
                </router-link>
           <!--  -->
                

            </div>
           
                   
              </div>
    </div>
           
           
</div>
</template>

<script>

    export default {
        data() {
            return {
                plans: {
                    data: []
                }
            }
        },

        mounted() {
            this.$Progress.start();

            axios.get('/api/plans').then((res) => {
                this.$Progress.finish();
                this.plans = res.data;
            }).catch((err) => {
                this.$Progress.finish();
                console.log(err);
            });

            console.log('Home Component mounted.')
        }
    }
</script>