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
<?php if(isset($_SESSION['UserId']))
{
    echo <<<EOF
            <ul class="breadcrumb">
              <li><a href="/blog">Home</a></li>
              <li class="active">create Blog Entity</li>
            </ul>
            <div id="newBlogInp" class="well bs-component">
                <form class="form-horizontal" method="post" action="$src" enctype="multipart/form-data">
                  <fieldset>
                    <legend>Create a new Blog</legend>
                    <div class="form-group">
                      <label for="blogName" class="col-lg-2 control-label">Title</label>
                      <div class="col-lg-10">
                        <input required name="blogName" type="text" class="form-control" id="blogName" value="$blogName" placeholder="Title">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="blogText" class="col-lg-2 control-label">Text</label>
                      <div class="col-lg-10">
                        <textarea required name="blogText" class="form-control" rows="3" id="blogText">$blogText</textarea>
                        <span class="help-block">Here you can write the description of your Blog to show the world the beauty of your Blog.</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="categorie" class="col-lg-2 control-label">Categorie</label>
                      <div class="col-lg-10">
                        <select class="form-control" id="categorie" name="categorieId">
EOF;
    foreach($categories as $cat) {
        if (isset($category) && $category == $cat) {
            echo '<option selected>'.$cat.'</option>';
        } else {
            echo '<option>'.$cat.'</option>';
        }
    }
    echo <<<EOF
                        </select>
                      </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="fileUpload" class="col-lg-2 control-label">Picture</label>
                        <div class="col-lg-10>
                            <input type="file" name="fileUpload" id="fileUpload">
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                      <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </fieldset>
                </form>
           </div>
EOF;

} ?>