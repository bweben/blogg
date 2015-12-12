<div class="container">
    <div class="form">
	    <?php if (isset($_SESSION['UserId'])) {
            echo <<<EOF
            <ul class="breadcrumb">
              <li class="active">Home</li>
            </ul>
           <div class="jumbotron">
                <h1>New Blog</h1>
                <p>Here you can create a new Blog and share your informations across the world.</p>
                <p><a class="btn btn-primary btn-lg" href="/Blog/create">Create</a></p>
            </div>
EOF;
        } ?>
    </div>
    <div class="form">
        <?php for($i = 0; $i < count($blogs);$i ++) {
            echo '
            <div class="panel panel-default">
              <div class="panel-heading">'.$blogs[$i][0].'<a href="/Blog/index/'.$blogs[$i][6].'">'.$blogs[$i][4].'</a></div>
              <div class="panel-body">
                <p>
                    '.$blogs[$i][1].'
                </p>
              </div>
            </div>';

        } ?>
    </div>
