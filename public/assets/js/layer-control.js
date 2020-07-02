// Code executes after page was loaded
$(document).ready( function () {
    getLayers();

    $(document).on ("click", ".delete", function () {
        deleteLayer(this);
    });
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
        let style = JSON.parse(layer["style"]);

        modal.find('.modal-title').text('Editing layer "' + layer["name"] + '" (id=' + layer['id'] +')');
        $("#name").val(layer["name"]);
        $("#id").val(id);
        $("#strokeColor").val(style["stroke"]["color"]);
        $("#strokeWidth").val(style["stroke"]["width"]);
        $("#pointColor").val(style["circle"]["fill"]["color"]);
        $("#pointRadius").val(style["circle"]["radius"]);
    })
})

// Modal submits
$("#layerForm").submit(function (event) {
    event.preventDefault();
    let url = "./layers/change.php";
    let input = JSON.stringify($("#layerForm").formToJson());

    $.post("./layers/change.php", input, function (data, status) {
        if(data) {
            getLayers();
            $("#editModal").modal("hide");
        }
    })
})
// Get attribute from string (OpenLayers style)
function getElement(style, figure, attr) {
    let start = style.indexOf(figure);
    let startAll = style.substring(start);
    let end = startAll.indexOf("})");
    let part = startAll.substring(0, end);
    let elementIndex = startAll.indexOf(attr);
    let element1 = part.substring(elementIndex + attr.length + 3);
    let elementLastSymb = element1.indexOf("'");
    let element = element1.substring(0, elementLastSymb);
    console.log(element);

    json = '{\n' +
        '  "stoke": {\n' +
        '    "color": "blue"\n' +
        '  },\n' +
        '  "circle": {\n' +
        '    "radius": "5",\n' +
        '    "fill": {\n' +
        '      "color": "orage"\n' +
        '    }\n' +
        '  }\n' +
        '}';

    let fjson = JSON.parse(json);
    console.log(fjson);
}

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
    acceptedFiles:".kml",
    parallelUploads: 1,
    dictDefaultMessage: "Drop layers(*.KML) here to upload",
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


