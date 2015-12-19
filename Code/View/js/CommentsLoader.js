/**
 * Created by natha on 15.12.2015.
 * sets the comments in the Blog Entity Overview
 */

/**
 * sets all things up
 * @param data
 */
function setCommentsView(data) {
    var blogId = data[data.length-1];
    var commentsDiv = $("#"+blogId);
    console.log(commentsDiv.children().length);
    if (commentsDiv.children().length == 0) {
        data.pop();
        commentsDiv.append('<div class="list-group">');
        $.each(data, function(i, entry) {
            console.log("Entry"+entry);
            var comments = '<li href="/Blog/index/'+entry[2]+'" class="list-group-item">'+
                '<h4 class="list-group-item-heading">'+entry[3]+'</h4>'+
                '<p class="list-group-item-text">'+entry[0]+'</p>'+
                '</li>';
            commentsDiv.append(comments);
        });

        var newcomment =
            '<li class="list-group-item">'+
            '<div id="newComment" class="col-lg-6 clearfix">'+
            '<div class="input-group" style="margin-left:0">'+
            '<input id="newCommentInp" required type="text" name="Text" class="form-control" placeholder="Write a comment...">'+
            '<span class="input-group-btn">'+
            '<button class="btn btn-primary" type="button" onclick="sendComment('+blogId+')"><span class="glyphicon glyphicon-send"></span></button>'+
            '</span>'+
            '</form>'+
            '</div><!-- /input-group -->'+
            '</div>'+
            '<div class="clearfix">'+
            '</div>'+
            '</li>';

        //commentsDiv.append(newcomment);   //doesn't function yet

        // old version
        if (data.length == 0) {
            commentsDiv.append('<h4>No Comments</h4><p>Create one <a href="/blog/read/'+
                blogId+'">here</a>!</p>')
        }
        commentsDiv.append('</div>')
    } else {
        commentsDiv.empty();
    }
}

/**
 * is being called if an error exists
 * @param data
 */
function errorfunc(data) {
    console.log("Error: "+data);
}

/**
 * loads comments, when you click on the comments link
 * @param id
 */
function loadComments(id) {
    $.ajax({
        type: "POST",
        url: "/DataComments/read/"+id,
        data: {ID: id},
        success: setCommentsView,
        dataType: "json",
        error: errorfunc
    });
}


/**
 * used to create comments
 * @param id
 */
/*
function sendComment(id) {
    var inputValue = $("newCommentInp").val();
    $.ajax({
        type: "POST",
        url: "/comments/create/"+id,
        data: {Text: inputValue},
        success: setSuccess,
        dataType: "json"
    });
}

function setSuccess(data) {
    var toappend = '<div id="message-alert" class="alert alert-dismissible alert-success">' +
        '<button type="button" class="close" data-dismiss="alert">×</button>'+
        '<h4>Success</h4>' +
        '<p>You created successfully a comment.</p>' +
        '</div>';
    $(".container").append(toappend);
    $("#message-alert").delay(1000*4).fadeOut(500);
}
*/