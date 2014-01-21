<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="public/css/vendor/bootstrap.css"></link>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="public/js/bootstrap.js"></script>
</head>
<body style="padding-top:20px;">
    <div id="wrap">
    <div class="container">
        <div class="header">
            <img src="public/img/phlego.png" alt="" height="300" width="400">
            <ul class="nav nav-pills pull-right">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </div>
        <div class="jumbotron">
            <h1><?php echo $title; ?></h1>
            <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
        </div>

        <div class="row">

            <div class="col-xs-4"><?php echo $leftContent; ?></div>
            <div class="col-xs-8"><?php echo $rightContent; ?></div>
            
        </div>
    </div>
</div>    <div id="footer">
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
</div>
</body>
</html>