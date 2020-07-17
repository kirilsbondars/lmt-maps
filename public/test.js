//Override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

// html
function getPanelTableRow(layer) {
    let id = layer["id"];
    let name = layer["name"];
    let style = JSON.parse(layer["style"]);
    let length = layer["length"];

    let row = '<tr>';
    row += '<td class="first">';
    row += '<input type="checkbox" data-id="' + id +'" data-length="' + length + '" title="Check to display layer"/>';
    row += '</td>';
    row += '<td class="second" title="' + name +'">' + name + '</td>';
    row += '<td class="third">';
    row += '<div style="display: table; border-spacing: 3px; border-collapse: separate;">';
    row += '<div class="stroke" style="width: 7px; height: 18px; background-color: ' + style["stroke"]["color"] +'; display: table-cell; cursor: pointer" title="Color of stroke"></div>';
    row += '<div class="circle" style="width: 18px; height: 18px; background-color: ' + style["circle"]["fill"]["color"] +'; border-radius: 18px; display: table-cell; cursor: pointer" title="Color of point"></div>';
    row += '</div>';
    row += '</td>';
    row += '<td class="forth">';
    row += '<div class="btn-group" role="group">';
    row += '<button class="btn btn-secondary actions edit" data-toggle="modal" data-target="#editModal" data-id="' + id + '" title="Edit layer"><i class="fa fa-edit" aria-hidden="true"></i></button>';
    row += '<a href="files/download_files.php?ids=[' + id +']" class="btn btn-secondary actions download" title="Download layer" role="button" aria-pressed="true"><i class="fa fa-download" aria-hidden="true"></i></a>';
    row += '<button class="btn btn-secondary actions delete" data-id="' + id + '" data-name="' + id + '" title="Delete layer"><i class="fa fa-times" aria-hidden="true"></i></button>';
    row += '</div>';
    row += '</td>';
    row += '</tr>';

    return row;
}

// VARIABLE
let panelTable = $("#layersTable");
let panelTableTbody = panelTable.find("tbody")

// FUNCTIONS
$(window).on('load', function() {
    updatePanelTable();
});

function updatePanelTable() {
    $.post("test/layer/get_all.php", function (json) {
        console.log(json);
        let layers = JSON.parse(json);

        layers.forEach(function (item, index) {
            let row = getPanelTableRow(item);
            panelTableTbody.append(row);
        })
    })
}

// FILE UPLOAD
// DropZone KML files settings
Dropzone.options.fileUploadKML = {
    url: "test/file/upload.php",
    paramName: "fileToUpload",
    Filesize: 200,
    acceptedFiles:".kml, .txt",
    parallelUploads: 1,
    dictDefaultMessage: "Drop layer(s) in KML or TXT(custom lmt format) here to upload",
    timeout: 99999,
    init: function(){
        let myDropzone = this;

        myDropzone.on("sending", function (file, xhr, formData) {
            formData.append("category", 1);
        })

        myDropzone.on("success", function (file, response) {
            myDropzone.removeFile(file);
            alertify.success("File has been uploaded, id = " + response);
            console.log("File has been uploaded, id = " + response);
        })

        myDropzone.on("error", function (file, response) {
            console.log(response);
        })
    },
};