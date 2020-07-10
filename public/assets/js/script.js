//override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

// Actions after page is load
$(window).on('load', function() {
    mapShow();
    updateLayersTable();

    $(document).on ("click", ".delete", function () {
        deleteLayer(this);
    });
});

let layers = {}, map;

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

// Get layers to the table
function updateLayersTable() {
    $.post("./layers/get_table.php", function (data) {
        $("#layersTable tbody").html(data);
    });
}

// Show layer on the map
$(document).on('click','.checkboxLayer',function(){
    let style;
    let id = $(this).data("id");
    let checked = $(this).prop("checked");

    console.log(id + " " + checked);

    $.ajax({
        url : "./layers/get_layer_style.php?id=" + id,
        type : "get",
        async: false,
        success : function (data, status) {
            style = JSON.parse(data);
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
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: style["stroke"]["color"],
                        width: style["stroke"]["width"]
                    }),
                    image: new ol.style.Circle({
                        radius: style["circle"]["radius"],
                        fill: new ol.style.Fill({
                            color: style["circle"]["fill"]["color"]
                        })
                    })
                })
            });
        }

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

// Delete action button
function deleteLayer(layer) {
    let id = $(layer).data("id");
    let name = $(layer).data("name");
    console.log(id);

    alertify.confirm('Confirm delete', 'Do you want to delete layer <b><em>"' + name + '"</em></b> (id=' + id +')' + '?',
        function(){
            $.get('layers/delete.php?id=' + id, function (data, status) {
                console.log(data);
                if(data == true) {
                    alertify.success('<b><em>' + name + '</em></b> (id=' + id + ') has been deleted', 3);
                    $(layer).parents("tr").addClass("table-danger").hide(500);
                } else {
                    alertify.error('<b><em>' + name + '</em></b> (id=' + id + ') has not been deleted', 3);
                }
            })
        },
        function(){});
}



