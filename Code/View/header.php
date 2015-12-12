
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="/View/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/View/css/stylesheet.css" rel="stylesheet">

    <script src="/View/js/jquery.js"></script>
    <script src="/View/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <script src="/View/bootstrap/bootstrap-3.3.6-dist/js/npm.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/Blog">Blog</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/Blog">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="/Blog/create">Create new</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['UserId'])) { echo '<li><a href="/Login/logout">'.$_SESSION['UserName'].'</a></li>';}
                else { echo '<li><a href="/Login/login">Login</a></li>'; } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container" role="main">
    <div class="page-header">
        <h1><?php echo $heading; ?></h1>
    </div>
    <script src="/View/js/jquery.js"></script>
    <script src="/View/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
