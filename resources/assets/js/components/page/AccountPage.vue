<template>
    <div class="container">
        <div class="row mt">
            


            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your Password</div>

                    <div class="panel-body">
                    <form @submit.prevent="changepassword()">
                       <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Old Password</label>
                        <input id="email" type="password" class="form-control" data-vv-name="oldpassword" v-validate="'required'" v-model="oldpassword" value="">
                        <div class="help-block alert alert-danger" v-show="errors.has('oldpassword')">{{ errors.first('oldpassword') }}</div>
                        </div>

                        <div class="form-group">
                        <label for="email" class="col-md-4 control-label">New Password</label>
                        <input id="email" type="password" class="form-control" data-vv-name="newpassword" v-validate="'required|min:6'" v-model="newpassword" value="">
                        <div class="help-block alert alert-danger" v-show="errors.has('newpassword')">{{ errors.first('newpassword') }}</div>
                        </div>

                        <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Confirm Password</label>
                        <input id="email" type="password" class="form-control" data-vv-name="confirmpassword" v-validate="'required|min:6'" v-model="confirmpassword" value="">
                        <div class="help-block alert alert-danger" v-show="errors.has('confirmpassword')">{{ errors.first('confirmpassword') }}</div>
                        </div>

                         <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>

                                
                            </div>
                        </div>

                        </form>

                    </div>
                </div>

                
            </div>

            <div class="col-md-2">
                <div class="text-center mt">
                    <img class="img-circle" :src="$root.auth.avatar" :alt="$root.auth.name">
                    <h4>{{ $root.auth.name }} <br>
                        <small>{{ $root.auth.email  }}</small></h4>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your Profile</div>

                    <div class="panel-body">
                      <div class="col-md-2">
                            <img :src="image" class="img-responsive">
                        </div>
                        <div class="col-md-8">
                            <input type="file" v-on:change="onFileChange" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success btn-block" @click="uploadProfileImage">Upload</button>
                        </div> 
                    </div>
                </div>

                
            </div>

            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your Card</div>
                    
                    <div class="panel-body">
                        
                    </div>
                </div>

                
            </div>
           
            <div class="col-md-10" v-if="isSubscribed ==='Subscribed'">
                <div class="panel panel-default">
                    <div class="panel-heading">Cancel Your Subscription</div>
                        <button type="submit" class="btn btn-primary" @click="cancel()">
                                    Cancel Your Subscription
                                </button>
                    <div class="panel-body">
                        
                    </div>
                </div>

               
            </div>
          
            <div class="col-md-10" v-else-if="isSubscribed ==='OnGracePeriod'">
                <div class="panel panel-default">
                    <div class="panel-heading">Resume Your Subscription</div>
                        <button type="submit" class="btn btn-primary" @click="resume()">
                                    Resume Your Subscription
                                </button>
                    <div class="panel-body">
                        
                    </div>
                </div>

                
            </div>

           
           
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Danger Zone</div>

                    <div class="panel-body">
                        <button type="submit" class="btn btn-primary" @click="deleteaccount()">
                                    Delete Account
                         </button>
                    </div>
                </div>

                
            </div>


           


        </div>
    </div>
</template>

<style scoped>
    img{
        max-height: 170px;
    }
</style>

<script>
    let vm = {}
    export default {
        data() {
            return {
                
                isSubscribed:'',  
                oldpassword:'',
                newpassword:'',
                confirmpassword:'',
                image: ''
                             
            }
        },
        created () {
          vm = this;
        },
        mounted() {


             this.$Progress.start();

                //Fetch plan id from the stripe
                axios.get('/api/isUserSubscribed').then((res) => {

                this.isSubscribed=res.data.trim();
                this.$Progress.finish();
                    
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                
                // this.$router.go(this.$router.currentRoute);
                
        },

        methods: {

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            cancel(){
             
                
                this.$Progress.start();

                //Fetch plan id from the stripe
                axios.get('/api/cancel').then((res) => {
                    this.$Progress.finish();
                    
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                this.$toasted.success('Your Subscription has been cancelled successfully! Sorry to see you go!')

                //Send email to user for subscription cancellation
                axios.get('/api/sendemail').then((res) => {
                    console.log(res.data);
                }).catch((err) => {
                    
                    console.log(err);
                });

                 //To refresh the current page
                this.$router.go(this.$router.currentRoute);

            },

            resume(){
                this.$Progress.start();

                //Fetch plan id from the stripe
                axios.get('/api/resume').then((res) => {
                    this.$Progress.finish();
                    
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                this.$toasted.success('Your Subscription has been resumed successfully! Happy to see you again!')
                 //To refresh the current page
                this.$router.go(this.$router.currentRoute);

            },

            changepassword() {
            
         

            this.$validator.validateAll().then(()=>{
                    this.$Progress.start();
                    axios.post('/api/changepassword', this.$data).then((res) => {
                    this.$Progress.finish();
                    
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);


                });

                 this.$toasted.success('Your Password has been changed successfully!')
                 //To refresh the current page
                 this.$router.go(this.$router.currentRoute);
                 })

               
 
            },

            deleteaccount(){

                this.$swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                      // this.$Progress.start();

                    //Fetch plan id from the stripe
                    axios.get('/api/deleteaccount').then((res) => {
                        // this.$Progress.finish();
                        
                        
                    }).catch((err) => {
                        this.$Progress.finish();
                        console.log(err);
                    });

                    // this.$toasted.success('Your account has been deleted! Sorry to see you again!');
                });

               //  this.$Progress.start();

               //  //Fetch plan id from the stripe
               //  axios.get('/api/deleteaccount').then((res) => {
               //      this.$Progress.finish();
                    
                    
               //  }).catch((err) => {
               //      this.$Progress.finish();
               //      console.log(err);
               //  });

                // this.$toasted.success('Your account has been deleted! Sorry to see you again!');
               // // this.$router.push('/');
            },

            uploadProfileImage(){
               this.$Progress.start();

                //Fetch plan id from the stripe
                axios.post('/api/uploadprofileimage',{image: this.image}).then((res) => {
                    this.$Progress.finish();
                    vm.$router.go(vm.$router.currentRoute);
                    
                    
                }).catch((err) => {
                    this.$Progress.finish();
                    console.log(err);
                });

                this.$toasted.success('Your profile picture has been uploaded successfully!') 
                // this.$router.go(this.$router.currentRoute);
            }

        }
    }
</script>