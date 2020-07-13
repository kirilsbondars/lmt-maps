//override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

//var layers_info = {};
let layers = [], map;

// Actions after page is load
$(window).on('load', function() {
    mapShow();
    updateLayersTable();

    $(document).on("click", ".delete", function () {
        deleteLayer(this);
    });
});

// Map
function mapShow() {
    let layer_map = new ol.layer.Tile({
        source: new ol.source.OSM()
    });

    map = new ol.Map({
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
}

// Show layer on the map
$(document).on('click','.checkboxLayer',function(){
    let style;
    let id = $(this).data("id");
    let checked = $(this).prop("checked");

    $.ajax({
        url : "layers/get_style.php?id=" + id,
        type : "get",
        async: false,
        success : function (data, status) {
            style = JSONToStyle(data);
        }
    });

    if (checked) {
        if (layers[id] === undefined) {
            layers[id] = new ol.layer.Vector({
                source: new ol.source.Vector({
                    url: './layers/get_layer.php?id=' + id,
                    format: new ol.format.KML({
                        extractStyles: false
                    })
                })
            });
        }

        layers[id].setStyle(style);
        layers[id].set("id", id);
        map.addLayer(layers[id]);
        console.log("Added layer with id = " + id + " to the map" + checked);
    } else {
        map.removeLayer(layers[id]);
        console.log("Deleted layer with id = " + id + " to the map" + checked);
    }
})

//// EDIT MODAL
// Clear form on close
$('#editModal').on('hide.bs.modal', function (event) {
    //clearFormInputs();
})
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
    $("#layerForm").find(":input").each(function() {
        fields[this.name] = $(this).val();
    });
    let style = styleToJSON(fields);

    let id = fields.id;

    let input = {
        "name": $("#layerForm").find("#name").val(),
        "style": style
    };

    $.post("layers/change.php?id="+id, {layer: input}, function (data, status) {
        if(data == true) {
            console.log("Info about layer with id = " + id + " has been changed");
            $("#editModal").modal("hide");

            updateRow(id);

            map.getLayers().forEach(function (layer) {
                if(layer.get("id") == id) {
                    layer.setStyle(JSONToStyle(input["style"]));
                }
            });
        }
    })
})

// Delete button action
function deleteLayer(layer) {
    let id = $(layer).data("id");
    let name = $(layer).data("name");

    alertify.confirm('Confirm delete', 'Do you want to delete layer <b><em>"' + name + '"</em></b> (id=' + id +')' + '?',
        function(){
            $.get('layers/delete.php?id=' + id, function (data, status) {
                if(data == true) {
                    console.log("Layer with id = " + id + " has been deleted");
                    alertify.success('<b><em>' + name + '</em></b> (id=' + id + ') has been deleted', 3);
                    $(layer).parents("tr").addClass("table-danger").hide(500);

                    if($("#layersTable tbody").find("tr").length == 1) {
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
}

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


