//override defaults for alertifyjs
alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";

$(window).on('load', function() {
    mapShow();
    updateLayersList();
});

let layers = {}, map;

function mapShow() {
    let layer_map = new ol.layer.Tile({
        source: new ol.source.OSM()
    });

    map = new ol.Map({
        controls: [],
        target: 'map',
        layers: [layer_map],
        view: new ol.View({
            center: ol.proj.fromLonLat([24.6032, 56.8796]),
            zoom: 7
        })
    });

    // map.addControl(new ol.control.Zoom({
    //     className: 'custom-zoom'
    // }));
}

function updateLayersList() {
    $.post("./layers/get_files_names_checkbox.php", function (data) {
        $("#choice_layers").html(data);
    });
}

$(document).on('click','#choice_layers input:checkbox',function(){
    let id = $(this).val();
    let style;

    console.log($(this).val() + " " + $(this).prop("checked"));

    $.ajax({
        url : "./layers/get_layer_style.php?id=" + id,
        type : "get",
        async: false,
        success : function (data, status) {
            style = JSON.parse(data);
        }
    });

    if ($(this).prop("checked")) {
        if (layers[$(this).val()] === undefined) {
            layers[$(this).val()] = new ol.layer.Vector({
                source: new ol.source.Vector({
                    url: './layers/get_layer.php?file=' + $(this).val(),
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

        map.addLayer(layers[$(this).val()]);
    } else {
        map.removeLayer(layers[$(this).val()]);
    }
})

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

// AlertifyJS confirm delete // make check if file is deleted
$('.delete').on('click', function () {
    let id = $(this).data("id");
    let name = $(this).data("name");
    console.log(id);

    alertify.confirm('Confirm delete', 'Do you want to delete layer <b><em>"' + name + '"</em></b> (id=' + id +')' + '?',
        function(){
            $.get('layers/delete.php?id=' + id, function (data, status) {
                alertify.success('<b><em>' + name + '</em></b> (id=' + id + ') has been deleted', 3);
            })
        },
        function(){});
})


