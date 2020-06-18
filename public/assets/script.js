// var style = new Style({
//     fill: new Fill({
//         color: 'rgba(255, 255, 255, 0.6)'
//     }),
//     stroke: new Stroke({
//         color: '#FFFFFF',
//         width: 10
//     })
// });

// import PLS1 from '../data/PLS1.kml';
// import PLS2 from '../data/PLS2.kml';
// import magistralaOptika from '../data/Maģistrālā optika.kml';
// import torniPlanoti from '../data/Torņi LMT plānoti pieslēgt.kml';
// import torniPieslegti from '../data/Torņi planoti pieslegt.kml';

window.onload = mapShow;
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

$("#choice_layers input:checkbox").click(function() {
    console.log($(this).val() + " " + $(this).prop("checked"));

    if ($(this).prop("checked")) {
        if (layers[$(this).val()] === undefined) {
            layers[$(this).val()] = new ol.layer.Vector({
                source: new ol.source.Vector({
                    url: './data/' + $(this).val(),
                    format: new ol.format.KML()
                })
            });
        }

        map.addLayer(layers[$(this).val()]);
    } else {
        map.removeLayer(layers[$(this).val()]);
    }
})