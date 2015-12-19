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
        <ul class="list-group">
            <?php
            $letter = 'A';
            $html = "";
            $letters = array();

            if (count($users) < 1 || !(isset($_SESSION['UserId']))) {
                echo <<<EOF
                    <div class="jumbotron">
                      <h1>Sign Up</h1>
                      <p>It seems that you signed in. Sign up or sign in to enter the most powerful Blog website you'd ever found.</p>
                      <p><a class="btn btn-primary btn-lg" href="/">Sign up</a></p>
                    </div>
EOF;

            }

            for ($i = 0; $i < count($users);$i++) {
                if (strtoupper(substr($users[$i][2],0,1)) != $letter) {
                    $letter = strtoupper(substr($users[$i][2],0,1));
                    $letters[] = $letter;
                    $html.='<li id="'.$letter.'" class="list-group-item">';
                    $html.='<span class="badge"><a href="#" class="glyphicon glyphicon-chevron-up"></a></span>';
                } else {
                    $html.='<li class="list-group-item">';
                }

                if ($_SESSION['Admin']) {
                    $html.='<span class="badge"><a href="/user/delete/'.$users[$i][0].'" class="btn btn-danger btn-xs">Delete</a></span>';
                }

                $html.='<a href="/blog/index/'.$users[$i][0].'">'.$users[$i][2].'</a>';
                $html.='</li>';
            }

            echo '<ul class="pagination pagination-sm">';
            foreach ($letters as $letter) {
                echo '<li><a href="#'.$letter.'">'.$letter.'</a></li>';
            }
            echo '</ul>';
            echo $html;
            ?>
        </ul>
    </div>