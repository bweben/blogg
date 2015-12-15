/**
 * Created by natha on 15.12.2015.
 */

$(document).ready(
    function() {
        loadComments(21);
    }
);

function setCommentsView(data) {
    console.log("Hallo");
    console.log(data);
    $.each(data, function(i, entry) {
        console.log(entry);
    });
}

function errorfunc(data) {
    console.log(data);
    alert("Error");
}

function loadComments(id) {
    console.log("Hello"+id);
    $.ajax({
        type: "POST",
        url: "/DataComments/read/",
        data: {ID: id},
        success: setCommentsView,
        dataType: "json",
        error: errorfunc
    });
}
