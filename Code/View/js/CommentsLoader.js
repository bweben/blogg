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
            var comments = '<a href="/Blog/index/'+entry[2]+'" class="list-group-item">'+
                '<h4 class="list-group-item-heading">'+entry[3]+'</h4>'+
                '<p class="list-group-item-text">'+entry[1]+'</p>'+
                '</a>';
            commentsDiv.append(comments);
            console.log("finito");
        });

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
