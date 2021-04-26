    ymaps.ready(init);
    function init(){ 
        
        var myMap = new ymaps.Map("map", {           
            center: [56.315059, 44.010793],            
            // Уровень масштабирования. Допустимые значения 0-19:            
            zoom: 10,
            controls: []
        });

        // Отключение масщтабирования при скроле
        //myMap.behaviors.disable('scrollZoom');

        myMap.controls.add("zoomControl", {
            position: {top: 15, left: 15}
        });

        var placemarks = new ymaps.GeoObjectCollection();

        for (idx in objects) {
            var object = objects[idx];
            placemarks[idx] = new ymaps.Placemark(object.coord, {
                id: object.id,
                hintContent: object.title,            
                rotation: object.rotation,                
                description: object.description,
                year: object.year,
                img: object.img
            }, 
            {
                iconLayout: 'default#imageWithContent',
                iconImageHref: '../images/icon/video-camera_inv.png',
                iconImageSize: [28, 28],
                //iconLayout: ymaps.templateLayoutFactory.createClass('<ymaps class="arrow-icon" style="transform: rotate($[properties.rotation]deg);"/>'),             
                iconImageOffset: [-14, -14],
                iconContentOffset: [14, 14],
                iconContentLayout: ymaps.templateLayoutFactory.createClass('<div class="arrow-icon" style="transform: rotate($[properties.rotation]deg);"></div>'),          
            });

            myMap.geoObjects.add(placemarks[idx]);
        }
        
        myMap.geoObjects.events.add('click', function (e) {
            //console.log(e.get('target').properties.get('id'));
            var mTitle = e.get('target').properties.get('hintContent');
            var mDescription = e.get('target').properties.get('description');
            var mYear = e.get('target').properties.get('year');
            var mImg = e.get('target').properties.get('img');

            fillModal(mTitle, mDescription, mYear, mImg);
            $('#showView').modal('show');
        });

        // Масштабируем карту на область видимости геообъектов.
        myMap.setBounds(myMap.geoObjects.getBounds(),{ checkZoomRange: true});

    }    

    $.getJSON("../json/point.json", function(data) {
        objects = data;
    });


//$(document).ready(function() {
    function fillModal(mTitle, mDescription, mYear, mImg)
    {
        $("#showView .modal-title").text(mTitle);
        $("#showView .main-img").attr("src", mImg);
        $("#showView .desrp").text(mDescription);
        $("#showView .badge-secondary").text(mYear+" год");
    }
//});