ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            center: [56.315059, 44.010793],
            zoom: 10,
            controls: []
        }, {
            searchControlProvider: 'yandex#search'
    });

    myMap.controls.add("zoomControl", {
        position: {top: 15, left: 15}
    });

    myGeoObject = new ymaps.GeoObject({
            geometry: {
                type: "Point",
                coordinates: [56.315059, 44.010793]
            },
            properties: {                
                balloonContent: 'Меня можно перемещать',
                hintContent: 'Меня можно перемещать',
                rotation: 0
            }
        }, {
            preset: 'islands#redDotIcon',
            'iconLayout': 'default#imageWithContent',
            'iconImageHref': '../images/icon/video-camera_inv.png',
            'iconImageSize': [28, 28],
            'iconImageOffset': [-14, -14],
            'iconContentOffset': [14, 14],
            'iconContentLayout': ymaps.templateLayoutFactory.createClass('<ymaps class="arrow-icon" id="point-$[id]" style="transform: rotate($[properties.rotation]deg);"></ymaps>'),    
            draggable: true
        });
    

    myGeoObject.events.add("dragend", function (e) {            
        var coords = e.get('target').geometry.getCoordinates();
        setCoordToForm(coords);
    });

    myMap.geoObjects.add(myGeoObject);

}

function setCoordToForm (coords) {
    var long = coords[0];   
    var lat = coords[1];
    $("#point_form_longitude").val(long);  
    $("#point_form_latitude").val(lat);    
}

$("#point_form_rotation").on("input",function(e){
    var res = Number($(e.target).val());
    myGeoObject.properties.set('rotation', res);
});
