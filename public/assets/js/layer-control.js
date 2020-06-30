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
    $.get("./layers/delete.php?id=" + layer.value, function () {
        let row = $("#" + layer.value).parents("tr");
        row.addClass("bg-danger");
        row.hide(400);
    })
}

// Modal content
$('#editModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.val();
    let modal = $(this);
    $.get("./layers/get_info.php?id=" + id, function (dataJSON, status) {
        let layer = JSON.parse(dataJSON);
        console.log(layer);
        modal.find('.modal-title').text('Editing layer "' + layer["name"] + '" (id=' + layer['id'] +')');
        //modal.find('.modal-body input').val(layer['name']);
        //modal.find('.modal-body textarea').val(layer['style']);
    })
})

// Get layer by id and print it in the table
function getLayerByIDPrintInTable(id) {
    $.get("./layers/get_layer_info_table.php?id=" + id, function (data, status) {
        $("#layersTables tbody").append(data);
        let row = $("#" + id).parents("tr");
        row.addClass("bg-success");
        setTimeout(function () {
            row.removeClass("bg-success");
        }, 1000);
    });
}

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

        // this.on("queuecomplete", function () {
        //     getLayers();
        // })

        this.on("success", function (file, response) {
            myDropzone.removeFile(file);
            getLayerByIDPrintInTable(response);
        })
    },
};

$("#strokeCheckBox").change(function (event) {
    console.log(event.checked);

})


