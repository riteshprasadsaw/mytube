<template>
    <div class="container">
        <div class="row mt">
            


            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your Password</div>

                    <div class="panel-body">
                    <form>
                       <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Old Password</label>
                        <input id="email" type="email" class="form-control" name="email" value="" required>
                        </div>

                        <div class="form-group">
                        <label for="email" class="col-md-4 control-label">New Password</label>
                        <input id="email" type="email" class="form-control" name="email" value="" required>
                        </div>

                        <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Confirm Password</label>
                        <input id="email" type="email" class="form-control" name="email" value="" required>
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

            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Danger Zone</div>

                    <div class="panel-body">
                        
                    </div>
                </div>

                
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>