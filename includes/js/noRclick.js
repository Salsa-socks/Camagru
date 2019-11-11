if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);

    document.onmousedown = function() {
        return false;
    };
} else {
    document.onmouseup = function(e) {
        if (e != null && e.type == "mouseup") {
            if (e.which == 2 || e.which == 3) {
                return false;
            }
        }
    };
}

document.oncontextmenu = function() {
    return false;
};

// document.oncontextmenu = document.body.oncontextmenu = function() {return false;}