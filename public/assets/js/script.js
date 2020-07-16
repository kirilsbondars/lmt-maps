//override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

var layers = [], map;

// Actions after page is load
$(window).on('load', function() {
    map = mapInitialize();
    updateLayersTable();
    updateSelectedLayersLength();
});

// Initialize map
function mapInitialize() {
    let layer_map = new ol.layer.Tile({
        source: new ol.source.OSM()
    });
    let map = new ol.Map({
        controls: [],
        target: 'map',
        layers: [layer_map],
        view: new ol.View({
            center: ol.proj.fromLonLat([22.8, 56.9]),
            zoom: 7
        })
    });
    map.addControl(new ol.control.Zoom({
        className: 'custom-zoom'
    }));

    return map;
}

// Show/hide layer on checkbox click
$(document).on('click','.checkboxLayer',function(){
    let checkbox = $(this);
    let id = checkbox.data("id");
    let checked = checkbox.prop("checked");

    if (checked) {
        if (layers[id] === undefined) {
            layers[id] = new ol.layer.Vector({
                source: new ol.source.Vector({
                    url: './layers/get_layer.php?id=' + id,
                    format: new ol.format.KML({
                        extractStyles: false
                    })
                })
            })
            layers[id].set("id", id);
            console.log("Layer with id " + id + " added to the array")
        }

        displayLayer(id);

    } else {
        map.removeLayer(layers[id]);
        console.log("Deleted layer with id = " + id + " to the map" + checked);
    }

    updateSelectedLayersLength();
})

// Updates data about length of selected layers in layers panel
function updateSelectedLayersLength() {
    let sumLength = 0;

    $(".checkboxLayer:checked").each(function () {
        sumLength += parseFloat($(this).data("length"));
    })

    sumLength = Math.round(sumLength * 1000) / 1000;

    $("#additionalInfo span").html(sumLength);
}


// Get style from db and display layer
function displayLayer(id) {
    updateStyle(id);
    map.addLayer(layers[id]);
    console.log("Added layer with id = " + id + " to the map");
}
// Update style
function updateStyle(id) {
    let url = "layers/get_style.php";
    $.post(url, {id: id}, function (data, status) {
        let style = JSONToStyle(data);
        layers[id].setStyle(style);
        console.log("Style of layer with id = " + id + " has been updated");
    })
}

//// EDIT MODAL
// Edit button action
$('#editModal').on('show.bs.modal', function (event) {
    let modal = $(this);
    let button = $(event.relatedTarget)
    let id = button.data("id");

    $.get("layers/get_info.php?id="+id, function (data, status) {
        let json = JSON.parse(data);
        let style = JSON.parse(json["style"])

        modal.find("#id").val(json["id"]);
        modal.find("#name").val(json["name"]);
        modal.find("#strokeColor").val(style["stroke"]["color"]);
        modal.find("#strokeWidth").val(style["stroke"]["width"]);
        modal.find("#pointRadius").val(style["circle"]["radius"]);
        modal.find("#pointColor").val(style["circle"]["fill"]["color"]);
    })
})
// Clear form inputs
function clearFormInputs() {
    $("#layerForm").find(":input").val("");
}
// Transform style to json
function styleToJSON(fields) {
    let style = '{"stroke":';
    style += '{"color":"' + fields.strokeColor + '","width":"' + fields.strokeWidth + '"},';
    style += '"circle":';
    style += '{"radius":"' + fields.pointRadius + '","fill":{"color":"' + fields.pointColor + '"}}}'

    return style;
}
function JSONToStyle(json) {
    let data = JSON.parse(json);

    let style = new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: data["stroke"]["color"],
            width: data["stroke"]["width"]
        }),
        image: new ol.style.Circle({
            radius: data["circle"]["radius"],
            fill: new ol.style.Fill({
                color: data["circle"]["fill"]["color"],
            })
        })
    });

    return style;
}
// Update row
function updateRow(id) {
    $.get("layers/get_info.php?id="+id, function (data, status) {
        let json = JSON.parse(data);
        let style = JSON.parse(json["style"]);
        let row = $("#"+id+" ")
        row.find(".second").text(json.name);
        row.find(".stroke").css("background-color", style["stroke"]["color"]);
        row.find(".circle").css("background-color", style["circle"]["fill"]["color"]);
    })
}
// Submit button
$("#layerForm").submit(function (event) {
    event.preventDefault();

    let fields = {}; // put form data to the object
    $(this).find(":input").each(function() {
        fields[this.name] = $(this).val();
    });
    let id = fields.id;
    let style = styleToJSON(fields);
    let name = $(this).find("#name").val()

    let input = {
        "name": name,
        "style": style
    };

    $.post("layers/change.php?id="+id, {layer: input}, function (data, status) {
        if(data === "1") {
            console.log("Info about layer with id = " + id + " has been changed");
            $("#editModal").modal("hide");

            updateRow(id);

            map.getLayers().forEach(function (layer) {
                if(layer.get("id") == id) {
                    updateStyle(id);
                }
            });

            alertify.success("Info about \"<em><b>" + name + "</b></em>\" layer with id = " + id + " <em>has been updated</em>", 3);
        } else {
            alertify.error("<b>Error</b> while updating info about \"<em><b>" + name + "</b></em>\" layer with id = " + id, 3);
        }
    })
})

// Delete button action
$(document).on("click", ".delete", function () {
    let layer = $(this);
    let id = layer.data("id");
    let name = layer.data("name");

    alertify.confirm('Confirm delete', 'Do you want to delete layer <b><em>"' + name + '"</em></b> (id=' + id +')' + '?',
        function(){
            $.post('layers/delete.php', {ids: "["+id+"]"}, function (data, status) {
                if(data === "1") {
                    console.log("Layer with id = " + id + " has been deleted");
                    alertify.success('<b><em>' + name + '</em></b> (id=' + id + ') has been deleted', 3);
                    $(layer).parents("tr").addClass("table-danger").hide(500);

                    if($("#layersTable tbody").find("tr").length === 1) {
                        setTimeout(function () {
                            updateLayersTable();
                        }, 500)
                    }

                    map.removeLayer(layers[id]);
                } else {
                    alertify.error('<b><em>' + name + '</em></b> (id=' + id + ') has not been deleted', 3);
                }
            })
        },
        function(){});
})

// Get layers to the table
function updateLayersTable() {
    let url = "layers/table/get_all.php";

    $.get(url, function (data) {
        $("#layersTable tbody").html(data);
        console.log("Layers table has been updated");
    });
}

//Get layer in row for table
function getLayerRow(id) {
    $.get("layers/table/get_row.php?id="+id, function (data, status) {
        let table = $("#layersTable tbody");
        if(table.find("tr").length === 0) {
            table.html("");
        }

        let row = $(data);
        row.hide().addClass("table-success").show(1000)
        setTimeout(function() { row.removeClass("table-success") }, 2000 );
        table.append(row);
        console.log("Layer with id = " + id + " has been added to table");
    })
}

// DropZone KML files settings
Dropzone.options.fileUploadKML = {
    paramName: "fileToUpload",
    Filesize: 200,
    acceptedFiles:".kml, .txt",
    parallelUploads: 1,
    dictDefaultMessage: "Drop layer(s) in KML or TXT(custom lmt format) here to upload",
    timeout: 99999,
    init: function(){
        let myDropzone = this;

        this.on("success", function (file, response) {
            myDropzone.removeFile(file);
            getLayerRow(response);
            console.log("File has been uploaded, it id as layer is " + response);
        })

        this.on("error", function (file, response) {
            console.log(response);
        })
    },
};

//// LAYERS MANAGER
let managerModal = $('#layersManagerModal');
let output = $("#selectedCheckboxes");
let selectedLayers = {"id": [], "name" : []};

// Action after opening the module
managerModal.on('show.bs.modal', function (event) {
    let modal = $(this);
    let url = "layers/manager_table/get_all.php";

    $.post(url, function (data, status) {
        modal.find("tbody").html(data);
    })

    selectedLayers = {"id": [], "name" : []};
    managerModal.find(":input").prop("checked", false);
    updateCheckedNumber();
})

// Collective select
managerModal.on("click", ".checkboxAll", function () {
    let checked = $(this);
    let checkboxes = managerModal.find("input[data-about=layer]");

    if(checked.prop("checked")) {
        checkboxes.prop("checked", "checked");
        checkboxes.each(function () {
            let checkbox = $(this);
            let id = checkbox.data("id");
            let name = checkbox.data("name");
            if(selectedLayers["id"].indexOf(id) < 0) {
                selectedLayers["id"].push(id);
                selectedLayers["name"].push(name);
            }
        })
    } else {
        checkboxes.prop("checked", false);
        checkboxes.each(function () {
            let checkbox = $(this);
            let id = checkbox.data("id");
            let name = checkbox.data("name");
            if(selectedLayers["id"].indexOf(id) >= 0) {
                removeItemOnce(selectedLayers["id"], id);
                removeItemOnce(selectedLayers["name"], name);
            }
        })
    }

    updateCheckedNumber();
    updateButtonsStates();
})

// Display in #selectedCheckbox how many layers are selected
function updateCheckedNumber() {
    let arr = selectedLayers["name"]
    let checkedNumber = arr.length;
    let checkedNames = "";

    arr.forEach(function (item, index) {
        if(index === checkedNumber - 1)
            checkedNames += item;
        else
            checkedNames += item + "; ";
    })

    output.text(checkedNumber + " layers are checked (" + checkedNames + ")");
}

function updateButtonsStates() {
    let checked = managerModal.find("input[data-about=layer]:checked");
    let downloadButton = $("#download");
    //let deleteButton = $("#delete");
    if(checked.length >= 1) {
        downloadButton.prop("disabled", false);
        //deleteButton.prop("disabled", false);
    } else {
        downloadButton.prop("disabled", "disabled");
        //deleteButton.prop("disabled", "disabled");
    }
}

function removeItemOnce(arr, value) {
    var index = arr.indexOf(value);
    if (index > -1) {
        arr.splice(index, 1);
    }
    return arr;
}

// Show how many checkboxes are checked
$(document).on("click","#layersManagerModal input[data-about=layer]",function(){
    let checkbox = $(this);
    let id = checkbox.data("id");
    let name = checkbox.data("name");

    if(checkbox.prop("checked")) {
        selectedLayers["id"].push(id);
        selectedLayers["name"].push(name);
    } else {
        removeItemOnce(selectedLayers["id"], id);
        removeItemOnce(selectedLayers["name"], name)
    }

    updateCheckedNumber();
    updateButtonsStates();
})

// Get selected layers data (format for ajax request)
function getSelectedLayers() {
    return JSON.stringify(selectedLayers["id"]);
}

// Download selected layers
function downloadLayers() {
    let data = getSelectedLayers();
    window.location = 'files/download_files.php?ids='+data;
}
