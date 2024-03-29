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
        con = 0;

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
        con = 1;
        context.drawImage(video, 0, 0, 500, 375);
        overlaycontext.drawImage(overlay, 0, 0, 400, 300);
        document.getElementById("canvas").style.zIndex = "1";
        document.getElementById("sticker").style.zIndex = "2";
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
        if (con == 1) {
            var layer1 = canvas.toDataURL('image/png');
            var layer2 = overlaycanvas.toDataURL('image/png');
            const url = "../includes/upload.php";
            var xhttp = new XMLHttpRequest();
            var values = "baseimage=" + layer1 + "&overlayimage=" + layer2;
            xhttp.open("POST", url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    var response = xhttp.responseText;
                    console.log(response);
                }
            }
            xhttp.send(values);
            alert("your picture has been uploaded");
        } else {
            alert("no picture has been taken");
        }
    });

})();

function uploader() {
    var upload = new Image(),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');

    upload.src = "../includes/usergallery/tmp/tmp.png";
    upload.onerror = function() {
        console.log("I know about the above error. \n This is how I check if there is a user uploaded image");
    };
    upload.onload = function() {
        context.drawImage(upload, 0, 0, 500, 375);
        document.getElementById("canvas").style.zIndex = "1";
    };
}

function camReset() {
    document.getElementById("canvas").style.zIndex = "-1";
}