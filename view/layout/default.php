<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Test Application</title>
    <!-- Favicons -->
    <link rel="icon" href="/assets/img/favicon-32x32.png" sizes="32x32" type="image/png">    
    <link rel="icon" href="/assets/img/favicon.ico">    
    <!-- Custom styles for this template -->
    <link href="/assets/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <meta name="theme-color" content="#563d7c">
  </head>
  <body>
    
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div id="menu" class="col-xl-12 col-lg-12 col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
                    <div class="container">
                        <a class="navbar-brand" href="/?task=index.index">Test Application</a>
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                            Menu <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarResponsive">
                          <ul class="navbar-nav ml-auto">
                                <?php if(isset($user)):?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/?task=profile.index">Profile</a>
                                </li>                                
                                <li class="nav-item">
                                    <a class="nav-link" href="/?task=profile.exit">Logout</a>
                                </li>
                                <?php endif;?>
                              
                          </ul>
                        </div>
                    </div>
                  </nav>
            </div>
        </div>
        <div class="row">
            <div id="content" class="col-xl-12 col-lg-12 col-md-12">
                <div class="container-fluid">
                    <?php echo $layoutContent?>
                    <?php if(isset($error)):?>
                    <div class="alert alert-danger" role="alert" style=" text-align: center ">
                        <?php echo $error?>
                    </div>                
                    <?php endif; ?>          
                    <?php if(isset($message) && empty($message) == false):?>
                    <div class="alert alert-success" role="alert" style=" text-align: center ">
                        <?php echo $message?>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>  
    <?php require("footer.php"); ?>
</body>
</html>
