function submit_comment(id) {
    var commentInput = document.getElementById("comment-input-" + id);
    var comment = commentInput.value;
    comment.replace("<", "&lt;");
    commentInput.value = "";

    var request = new XMLHttpRequest();

    request.addEventListener("load", () => {
        console.log(request.responseText);
    });

    request.open("POST", "/Camagru/functions/comment.php");
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    request.send(
        "id=" + id +
        "&comment=" + encodeURIComponent(comment)
    );
    location.reload();
}