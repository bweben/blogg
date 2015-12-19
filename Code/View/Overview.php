<div class="container">
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div id="message-alert" class="alert alert-dismissible alert-'.$_SESSION['message'][0].'">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<h4>'.$_SESSION['message'][1].'</h4>';
        echo '<p>'.$_SESSION['message'][2].'</p>';
        echo '</div>';
        unset($_SESSION['message']);
    }
    ?>
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
            echo "<p>There are no Blogs yet...</p>";
        }

        if (!isset($_SESSION['UserId'])) {
            echo "<p>Create a new Blog by sign in first <a href='/'>here</a>.</p>";
        }

        $html = "";
        $categories = array();
        for($i = 0; $i < count($blogs);$i ++) {
            if (!in_array(array($blogs[$i][5],$blogs[$i][9]),$categories)) {
                $categories[] = array($blogs[$i][5],$blogs[$i][9]);
            }

            $text = strlen($blogs[$i][1]) > 50 ? substr($blogs[$i][1],0,50).'...' : substr($blogs[$i][1],0,strlen($blogs[$i][1]));
            $html.='
            <div class="bs-component">
                <div class="panel panel-default">
                  <div class="panel-heading"><a href="/Blog/read/'.$blogs[$i][8].'">'.$blogs[$i][0].'</a> by: <a href="/Blog/index/'.$blogs[$i][6].'">'.$blogs[$i][4].'</a></div>
                  <div class="panel-body">
                    <p>
                        '.$text.'
                    </p>
                  </div>
                  <div class="panel-footer">
                    <a onclick="loadComments('.$blogs[$i][8].')">Comments <span class="badge">'.$blogs[$i][7].'</span></a>
                    <div id="'.$blogs[$i][8].'">
                    </div>
                  </div>
                </div>
            </div>';

        }

        echo '<h2>Categories</h2>';
        if (isset($category)) {
            echo '<a style="padding: 0 2px" href="/blog"><span class="label label-primary">All</span></a>';
        }

        foreach($categories as $cat) {
            echo '<a style="padding: 0 2px" href="/category/index/'.$cat[1].'"><span class="label label-default">'.$cat[0].'</span></a>';
        }

        echo '<h2>Blogs</h2>';
        echo $html;

        ?>
    </div>