/**
 * Created by natha on 15.12.2015.
 */

function setCommentsView(data) {
    console.log(data);
    var commentsDiv = $("#comments");
    commentsDiv.append('<div class="list-group">');
    $.each(data, function(i, entry) {
        console.log(entry);
        var comments = '<a href="/Blog/index/'+entry[2]+'" class="list-group-item">'+
            '<h4 class="list-group-item-heading">'+entry[3]+'</h4>'+
            '<p class="list-group-item-text">'+entry[1]+'</p>'+
        '</a>';
        commentsDiv.append(comments);
    });
    commentsDiv.append('<a class="list-group-item">');
    commentsDiv.append('<div class="list-group-item-text">');
    commentsDiv.append('<form action="/comments/create" method="post">');
    commentsDiv.append('<input type="text">');
    commentsDiv.append('<input type="submit" class="btn btn-primary">');
    commentsDiv.append('</div>');
    commentsDiv.append('</a>');
    commentsDiv.append('</div>')
}

function errorfunc(data) {
    console.log(data);
    alert("Error");
}

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
