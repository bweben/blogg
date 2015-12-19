<div class="clearfix"></div>
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
    <ul class="breadcrumb">
        <li><a href="/blog">Home</a></li>
        <li class="active">Blog Entity Overview</li>
    </ul>
    <?php if (isset($_SESSION['UserId'])) {
        if ($_SESSION['UserId'] == $blog[0][6]) {
            echo '<a href="/Blog/change/' . $blog[0][8] . '" class="btn btn-warning btn-xs">Change</a>';
        }
        if ($_SESSION['UserId'] == $blog[0][6] || $_SESSION['Admin']) {
            echo '<a href="/Blog/delete/' . $blog[0][8] . '" class="btn btn-danger btn-xs" data-dismiss="alert">Delete</a>';
        }
    } ?>

    <h3 style="margin-bottom: 0; margin-top: 0"><?php echo $blog[0][0]; ?></h3>

    <p style="font-size: 11px">by <a href="/blog/index/<?php echo $blog[0][6]; ?>"><?php echo $blog[0][4]; ?></a>
        <br><span class="glyphicon glyphicon-time"></span><?php echo date("G:i d.m.Y", $blog[0][2]); ?>
    </p>

    <p><?php echo str_replace("\n", "<br>", $blog[0][1]); ?></p>
</div>
</div>
<div class="container">
    <h2>Comments</h2>
    <?php
    $commentts = "<div class=\"list-group\">";
    for ($i = 0; $i < count($comments); $i++) {
        $commentts .= '<li id="commentDiv" href="/Blog/index/' . $comments[$i][2] . '" class="list-group-item">';
            if ($_SESSION['UserId'] == $blog[0][6] || $_SESSION['UserId'] == $comments[$i][2] || $_SESSION['Admin']) {
                $commentts .= '<a id="deleteComment" href="/Comments/delete/' . $comments[$i][4] . '/' . $blog[0][8] . '" class="pull-right">×</a>';
            }
            $commentts .= '<h4 class="list-group-item-heading">' . $comments[$i][3] . '</h4>'.
            '<p class="list-group-item-text">' . $comments[$i][0] . '</p>
                <span style="font-size:11px" class="glyphicon glyphicon-time" aria-hidden="true">' . date("G:i d.m.Y", $comments[$i][1]) . '</span>';
        $commentts .= '</li>';
    }
    if ($_SESSION['UserId'] == $blog[0][6] && count($comments) == 0) {
        $commentts .= "<p>No comments yet.</p>";
    }

    if ($_SESSION['UserId'] != $blog[0][6]) {
        $blogId = $blog[0][8];
        $commentts .= <<<EOF
                <li class="list-group-item">
                    <div id="newComment" class="col-lg-6 clearfix">
                        <form action="/comments/create/$blogId" method="post">
                        <div class="input-group" style="margin-left:0">
                            <input required type="text" name="Text" class="form-control" placeholder="Write a comment...">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-send"></span></button>
                          </span>
                          </form>
                        </div><!-- /input-group -->
                    </div>
                    <div class="clearfix">
                    </div>
                </li>
            </div>
EOF;
    } else {
        $commentts .= '</div>';
    }

    echo $commentts;
    ?>
