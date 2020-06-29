// Code executes after page was loaded
$(document).ready( function () {
    getLayers();

    $(document).on ("click", ".delete", function () {
        deleteLayer(this);
    })
});

// Load layers to the table
function getLayers() {
    $.post("./layers/get_layers_table.php", function (data, status) {
        $("#layersTables tbody").html(data);
    })
}

// Delete layer
function deleteLayer(layer) {
    $.get("./layers/delete.php?id=" + layer.value, function (dataJSON, status) {
        let data = JSON.parse(dataJSON);
        if(data["success"]) {
            let row = $("#" + layer.value).parents("tr");
            row.addClass("bg-danger");
            row.hide(400);
        }
    })
}

// Modal content


// DropZone settings
Dropzone.options.fileUpload = {
    paramName: "fileToUpload",
    Filesize: 200,
    acceptedFiles:".kml, .geojson",
    parallelUploads: 1,
    dictDefaultMessage: "Drop layers(*.KML, *.GEOJSON) here to upload",
    timeout: 99999,
    init: function(){
        let myDropzone = this;

        this.on("queuecomplete", function () {
            getLayers();
        })

        this.on("success", function (file) {
            myDropzone.removeFile(file);
        })
    },
};
