// var style = new Style({
//     fill: new Fill({
//         color: 'rgba(255, 255, 255, 0.6)'
//     }),
//     stroke: new Stroke({
//         color: '#FFFFFF',
//         width: 10
//     })
// });


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
    if($(this).prop("checked")) {
        rotate("#menuCheckBox img", 180);
        layerMenu(true, 1000);
    } else {
        rotate("#menuCheckBox img", 0);
        layerMenu(false, 1000);
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

function layerMenu(close, speed) {
    if(close) {
        let layersHeight = 0;

        $("#layers").children().each(function () {
            layersHeight += $(this).outerHeight();
        });
        $("#layers").animate({
            height: layersHeight + 25,
        }, speed);
    } else {
        $("#layers").animate({
            height: $( document ).height() - 20,
        }, speed);
    }
}


