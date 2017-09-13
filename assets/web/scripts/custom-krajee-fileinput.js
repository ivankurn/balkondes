$(document).on('ready', function() {
    $("#image-upload").fileinput({
        showUpload: false,
        showPreview: false,
        browseClass: "btn btn-primary",
        browseLabel: "Pilih Gambar",
        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
        removeClass: "btn btn-danger",
        removeLabel: "Hapus",
        removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
        elErrorContainer: "#errorBlock",
        maxFileSize: 1000,
        maxFilesNum: 1,
    });
});
