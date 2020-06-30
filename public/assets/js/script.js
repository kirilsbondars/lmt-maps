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
        layers: [layer_map],
        target: "map",
        view: new ol.View({
            center: [2738815.70, 7735549.67],
            projection: "EPSG:3857",
            zoom: 7
        })
    });
}

function updateLayersList() {
    $.post("./layers/get_files_names_checkbox.php", function (data) {
        $("#choice_layers").html(data);
    });
}

$(document).on('click','#choice_layers input:checkbox',function(){
    console.log($(this).val() + " " + $(this).prop("checked"));

    if ($(this).prop("checked")) {
        if (layers[$(this).val()] === undefined) {
            layers[$(this).val()] = new ol.layer.Vector({
                source: new ol.source.Vector({
                    url: './layers/get_layer.php?file=' + $(this).val(),
                    format: new ol.format.KML({
                        extractStyles: false
                    })
                }),
                // style: new ol.style.Style({
                //     stroke: new ol.style.Stroke({
                //         color: 'blue'
                //     })
                // })
            });
        }

        map.addLayer(layers[$(this).val()]);
    } else {
        map.removeLayer(layers[$(this).val()]);
    }
})