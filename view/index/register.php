<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="text-center form-signin-wrap">
            <form class="form-signin" action="/?task=index.register" method="post">
                <img class="mb-4" src="/assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Create Account</h1>
                
                <label for="inputName" class="sr-only">Name</label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" required autofocus minlength="3">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required >
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required minlength="4">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                <a href="/?task=index.index" class="btn btn-lg btn-default btn-block2" >Login</a>
            </form>
            
            
        </div>
    </div>                
    
</div>