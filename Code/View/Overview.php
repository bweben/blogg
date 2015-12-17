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
        <?php
        if (count($blogs) == 0) {
            echo "<h2>There are no Blogs yet</h2>";
        }

        if (!isset($_SESSION['UserId'])) {
            echo "<p>Create a new Blog by sign in first <a href='/'>here</a>.</p>";
        }

        for($i = 0; $i < count($blogs);$i ++) {
            echo '
            <div class="bs-component">
                <div class="panel panel-default">
                  <div class="panel-heading"><a href="/Blog/read/'.$blogs[$i][8].'">'.$blogs[$i][0].'</a> by: <a href="/Blog/index/'.$blogs[$i][6].'">'.$blogs[$i][4].'</a></div>
                  <div class="panel-body">
                    <p>
                        '.$blogs[$i][1].'
                    </p>
                  </div>
                  <div class="panel-footer">
                    <a onclick="loadComments('.$blogs[$i][8].')">Comments <span class="badge">'.$blogs[$i][7].'</span></a>
                    <div id="comments'.$blogs[$i][8].'">
                    </div>
                  </div>
                </div>
            </div>';

        } ?>
    </div>
