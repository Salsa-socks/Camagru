(function deleteFile() {
    var myObjct;
    myObjct = new ActiveXObject("Scripting.FileSystemObject");
    myObjct.DeleteFile("../includes/usergallery/*.png");
})