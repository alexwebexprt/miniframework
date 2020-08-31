<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="default-wrap">
            <div class="card col-xl-12 col-lg-12 col-md-12">
                <div class="card-header">
                    Welcome <b><?php echo $user->name;?></b>
                </div>
                <div class="card-body">
                    <form action="/?task=profile.update" method="post">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" placeholder="Your Name" required minlength="3" >
                        </div>
                        <div class="form-group">
                            <label for="email">Email (username):</label>
                            <input type="email" name="email" value="<?php echo $user->email;?>" class="form-control" placeholder="Enter email" id="email" required >
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" id="pwd" autocomplete="off">
                        </div>                        
                        <div class="form-group">
                            <label for="pwd">Confirm Password:</label>
                            <input type="password" name="password2" class="form-control" placeholder="Enter conform password" id="pwd" autocomplete="off">
                        </div>                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>