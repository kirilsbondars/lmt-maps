Dropzone.options.fileUpload = {
    paramName: "fileToUpload",
    Filesize: 200,
    acceptedFiles:".kml, .geojson",
    parallelUploads: 1,
    timeout: 999999,
    init: function(){
        let myDropzone = this;
        
        this.on("queuecomplete", function () {
            //alert("Uploading finished");
            //закрыть окно если нет ошибок
            //если есть ошибки вывести их alert bootstrap
        })

        this.on("success", function (file) {
            myDropzone.removeFile(file);
        })
    },

};