(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        vendorURL = window.URL || window.webkitURL;

    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.srcObject = stream;
        video.play();
    }, function(error) {

    });

    document.getElementById('capture').addEventListener('click', function() {
        context.drawImage(video, 0, 0, 500, 380);
        document.getElementById("canvas").style.zIndex = "1";
        console.log(canvas.toDataURL());
    });

    document.getElementById('upload').addEventListener('click', function() {
        var layer1 = canvas.toDataURL('image/png');
        // layer2 = null;
        // if (document.getElementById("overlay").hasAttribute("src")) {
        //     layer2 = canvasOverlay.toDataURL('image/png');
        // }
        const url = "../includes/upload.php";
        var xhttp = new XMLHttpRequest();
        var values = "baseimage=" + layer1;
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var response = xhttp.responseText;
                console.log(response);
            }
        }
        xhttp.send(values);
    });

})();

function camReset() {
    document.getElementById("canvas").style.zIndex = "-1";
}