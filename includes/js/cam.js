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
        // photo.setAttribute('src', canvas.toDataURL('image/png'));
    });
})();

function camReset() {
    document.getElementById("canvas").style.zIndex = "-1";
}