<div class="container">
    <div class="form">
        <?php if(isset($_SESSION['UserId'])) {
            if ($_SESSION['UserId'] == $blog[0][6]) {
                echo '<a href="/Blog/change/'.$blog[0][8].'" class="btn btn-default">Change</a>';
            }
            if ($_SESSION['UserId'] == $blog[0][6] || $_SESSION['Admin']) {
                echo '<a href="/Blog/delete/'.$blog[0][8].'" class="btn btn-danger">Delete</a>';
            }
        } ?>
    </div>
    <div class="form">
        <h2><?php echo $blog[0][0]; ?></h2>

        <p><?php echo str_replace("\n","<br>",$blog[0][1]); ?></p>
    </div>
</div>
    <div class="container">
        <h2>Comments</h2>
        <?php
        $commentts = "<div class=\"list-group\">";
        for($i = 0; $i < count($comments);$i++) {
    $commentts .='<a href="/Blog/index/'.$comments[$i][2].'" class="list-group-item">'.
                '<h4 class="list-group-item-heading">'.$comments[$i][3].'</h4>'.
                '<p class="list-group-item-text">'.$comments[$i][0].'</p>';
        if($_SESSION['UserId'] == $blog[0][6] || $_SESSION['UserId'] == $comments[$i][2] || $_SESSION['Admin']) {
            $commentts .= '<a style="display: block;" href="/Comments/delete/'.$comments[$i][4].'" class="btn btn-danger btn-xs">Delete</a>';
        }
            $commentts .= '</a>';
}
        if ($_SESSION['UserId'] != $blog[0][6]) {
            $blogId = $blog[0][8];
            $commentts .=<<<EOF
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
            $commentts.='</div>';
        }

        echo $commentts;
 ?>
        </div>
