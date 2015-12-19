<div class="container" style="margin-bottom: 0">
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div id="message-alert" class="alert alert-dismissible alert-' . $_SESSION['message'][0] . '">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo '<h4>' . $_SESSION['message'][1] . '</h4>';
        echo '<p>' . $_SESSION['message'][2] . '</p>';
        echo '</div>';
        unset($_SESSION['message']);
    }
    ?>
    <div class="form">
        <?php if (isset($_SESSION['UserId'])) {
            if ($_SESSION['UserId'] == $blog[0][6]) {
                echo '<a href="/Blog/change/' . $blog[0][8] . '" class="btn btn-default">Change</a>';
            }
            if ($_SESSION['UserId'] == $blog[0][6] || $_SESSION['Admin']) {
                echo '<a href="/Blog/delete/' . $blog[0][8] . '" class="btn btn-danger" data-dismiss="alert">Delete</a>';
            }
        } ?>
    </div>
    <div class="form">
        <h3 style="margin-bottom: 0; margin-top: 0"><?php echo $blog[0][0]; ?></h3>

        <p style="font-size: 11px">by <a href="/blog/index/<?php echo $blog[0][6]; ?>"><?php echo $blog[0][4]; ?></a>
        </p>

        <p><?php echo str_replace("\n", "<br>", $blog[0][1]); ?></p>
    </div>
</div>
<div class="container">
    <h2>Comments</h2>
    <?php
    $commentts = "<div class=\"list-group\">";
    for ($i = 0; $i < count($comments); $i++) {
        $commentts .= '<a href="/Blog/index/' . $comments[$i][2] . '" class="list-group-item">' .
            '<h4 class="list-group-item-heading">' . $comments[$i][3] . '</h4>' .
            '<p class="list-group-item-text">' . $comments[$i][0] . '</p>
                <span style="font-size:11px" class="glyphicon glyphicon-time" aria-hidden="true">' . date("G:i d.m.Y", $comments[$i][1]) . '</span>';
        if ($_SESSION['UserId'] == $blog[0][6] || $_SESSION['UserId'] == $comments[$i][2] || $_SESSION['Admin']) {
            $commentts .= '<a style="display: block;" href="/Comments/delete/' . $comments[$i][4] . '" class="btn btn-danger btn-xs">Delete</a>';
        }
        $commentts .= '</a>';
    }
    if ($_SESSION['UserId'] == $blog[0][6] && count($comments) == 0) {
        $commentts .= "<p>No comments yet.</p>";
    }

    if ($_SESSION['UserId'] != $blog[0][6]) {
        $blogId = $blog[0][8];
        $commentts .= <<<EOF
                <a class="list-group-item">
                <div class="list-group-item-text">
                    <form action="/comments/create/$blogId" method="post">
                    <input name="Text" type="text">
                    <input type="submit" class="btn btn-primary btn-sm">
                </div>
                </a>
            </div>
EOF;
    } else {
        $commentts .= '</div>';
    }

    echo $commentts;
    ?>
</div>
