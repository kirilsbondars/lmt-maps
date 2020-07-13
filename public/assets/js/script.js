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

    console.log(id + " " + checked);

    $.ajax({
        url : "layers/get_layer_style.php?id=" + id,
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
                }),
                style: style
            });
        }

        layers[id].set("id", id);

        map.addLayer(layers[id]);
    } else {
        map.removeLayer(layers[id]);
    }
})

// Layers menu small/big changer
$("#menuCheckBox input").change(function () {
    console.log($(this).prop("checked"));
    if($(this).prop("checked")) {
        closeLayerMenu(true, 1000);
    } else {
        closeLayerMenu(false, 1000);
    }
})
function rotate(element, degree, duration) {
    $(element).animate({deg: degree}, {
        duration: duration,
        step: function(now) {
            $(this).css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
}
function closeLayerMenu(close, speed) {
    if(close) {
        let layersHeight = 0;

        $("#layers").children().each(function () {
            layersHeight += $(this).outerHeight();
        });
        $("#layers").animate({
            height: layersHeight + 25,
        }, speed);

        rotate("#menuCheckBox i", 180, 1000);
    } else {
        $("#layers").animate({
            height: $( document ).height() - 20,
        }, speed);

        rotate("#menuCheckBox i", 0, 1000);
    }
}

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
        $("#"+id+" ")
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

    $.post("layers/change.php?id="+fields.id, {layer: input}, function (data, status) {
        if(data == true) {
            console.log("Info about layer with id = " + fields.id + " has been changed");
            $("#editModal").modal("hide");

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
                console.log(data);
                if(data == true) {
                    console.log("Layer with id = " + id + " has been deleted");
                    alertify.success('<b><em>' + name + '</em></b> (id=' + id + ') has been deleted', 3);
                    $(layer).parents("tr").addClass("table-danger").hide(500);
                    setTimeout(function () {
                        updateLayersTable();
                    }, 500)
                    console.log($("#layersTable tbody").find("tr").length);
                } else {
                    alertify.error('<b><em>' + name + '</em></b> (id=' + id + ') has not been deleted', 3);
                }
            })
        },
        function(){});
}

// Get layers to the table
function updateLayersTable() {
    let url = "layers/get_all_table.php";

    $.get(url, function (data) {
        $("#layersTable tbody").html(data);
        console.log("Layers table has been updated");
    });
}

//Get layer in row for table
function getLayerRow(id) {
    $.get("layers/get_table.php?id="+id, function (data, status) {
        if($("#layersTable tbody").find("tr").length === 0) {
            $("#layersTable tbody").html("");
        }

        let row = $(data);
        row.hide().addClass("table-success").show(1000)
        setTimeout(function() { row.removeClass("table-success") }, 2000 );
        $("#layersTable tbody").append(row);
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

// // Update layers data
// function updateLayersData() {
//     $.post("layers/get_all.php", function (data, status) {
//         layers_info = JSON.parse(data);
//     })
// }
//
// // Display layer row in table
// function displayRowInTable(layer) {
//
// }
//
// function displayLayersTable() {
//     return '<tr>' +
//         '    <td class="first">' +
//         '        <input type="checkbox" data-id="<?php echo $id?>" class="checkboxLayer" title="Check to display layer"/>' +
//         '    </td>' +
//         '    <td class="second"><?php echo $name?></td>' +
//         '    <td class="third">\n' +
//         '        <div style="display: table; border-spacing: 3px; border-collapse: separate;">\n' +
//         '            <div style="width: 7px; height: 18px; background-color: <?php echo $strokeColor?>; display: table-cell; cursor: pointer" title="Color of stroke"></div>\n' +
//         '            <div style="width: 18px; height: 18px; background-color: <?php echo $circleColor?>; border-radius: 18px; display: table-cell; cursor: pointer" title="Color of point"></div>\n' +
//         '        </div>\n' +
//         '    </td>\n' +
//         '    <td class="forth">\n' +
//         '        <div class="btn-group" role="group">\n' +
//         '            <button class="btn btn-secondary actions edit" data-toggle="modal" data-target="#editModal" data-id="<?php echo $id?>" title="Edit layer"><i class="fa fa-edit" aria-hidden="true"></i></button>\n' +
//         '            <a href="./layers/download_file.php?id=<?php echo $id?>" class="btn btn-secondary actions download" title="Download layer" role="button" aria-pressed="true"><i class="fa fa-download" aria-hidden="true"></i></a>\n' +
//         '            <button class="btn btn-secondary actions delete" data-id="<?php echo $id?>" data-name="<?php echo $name?>" title="Delete layer"><i class="fa fa-times" aria-hidden="true"></i></button>\n' +
//         '        </div>\n' +
//         '    </td>\n' +
//         '</tr>'
// }

