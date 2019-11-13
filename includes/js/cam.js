(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        overlaycanvas = document.getElementById('sticker'),
        context = canvas.getContext('2d'),
        overlaycontext = overlaycanvas.getContext('2d'),
        place1 = document.getElementById('place1'),
        place2 = document.getElementById('place2'),
        place3 = document.getElementById('place3'),
        place4 = document.getElementById('place4'),
        place5 = document.getElementById('place5'),
        overlay = document.getElementById('stick'),
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
        context.drawImage(video, 0, 0, 500, 375);
        overlaycontext.drawImage(overlay, 0, 0, 400, 300);
        document.getElementById("canvas").style.zIndex = "1";
        document.getElementById("sticker").style.zIndex = "2";
        // console.log(canvas.toDataURL());
        // console.log(overlaycanvas.toDataURL());
    });

    place1.addEventListener('click', function() {
        document.getElementById("stick").style.visibility = "visible";
        overlay.src = '../includes/stickers/sticker1.png';

    });

    place2.addEventListener('click', function() {
        document.getElementById("stick").style.visibility = "visible";
        overlay.src = "../includes/stickers/sticker2.png";
    });

    place3.addEventListener('click', function() {
        document.getElementById("stick").style.visibility = "visible";
        overlay.src = "../includes/stickers/sticker3.png";
    });

    place4.addEventListener('click', function() {
        document.getElementById("stick").style.visibility = "visible";
        overlay.src = "../includes/stickers/sticker4.png";
    });

    place5.addEventListener('click', function() {
        document.getElementById("stick").style.visibility = "visible";
        overlay.src = "../includes/stickers/sticker5.png";
    });

    document.getElementById('upload').addEventListener('click', function() {
        var layer1 = canvas.toDataURL('image/png');
        var layer2 = overlaycanvas.toDataURL('image/png');
        const url = "../includes/upload.php";
        var xhttp = new XMLHttpRequest();
        var values = "baseimage=" + layer1 + "&overlayimage=" + layer2;
        alert("Your image has been posted\nPlease refresh");
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