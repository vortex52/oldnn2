ymaps.ready(init);

function init () {
    myMap = new ymaps.Map('map', {
        center: [56.315059, 44.010793],
        zoom: 10,
        controls: []
    }, {
        searchControlProvider: 'yandex#search'
    });

    // Отключение масщтабирования при скроле
    //myMap.behaviors.disable('scrollZoom');

    myMap.controls.add("zoomControl", {
        position: {top: 15, left: 15}
    });

    // ObjectManager принимает те же опции, что и кластеризатор.
    objectManager = new ymaps.ObjectManager({            
        clusterize: true,            
        gridSize: 32,
        HasBalloon: false,
        clusterDisableClickZoom: false,            
        minClusterSize: 2,
        clusterIconLayout: ymaps.templateLayoutFactory.createClass('<ymaps class="arrow-icon-cluster"><strong>{{ properties.geoObjects.length }}</strong></ymaps>'),
        clusterIconShape: {
            type: 'Rectangle',
            coordinates: [[-15, -15], [30, 30]]
        }
    });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set({        
        'iconLayout': 'default#imageWithContent',
        'iconImageHref': '../images/icon/video-camera_inv.png',
        'iconImageSize': [28, 28],
        'iconImageOffset': [-14, -14],
        'iconContentOffset': [14, 14],
        'iconContentLayout': ymaps.templateLayoutFactory.createClass('<ymaps class="arrow-icon" id="point-$[id]" style="transform: rotate($[properties.rotation]deg);"></ymaps>'),            
    });

    myMap.geoObjects.add(objectManager);

    $.ajax({
        url: "json/data_admin.json"
    }).done(function(data) {
        objectManager.add(data);
        //Автоцентрирование карты по области точек менеджера
        myMap.setBounds(objectManager.getBounds());
    });    

    objectManager.objects.events.add('click', function (e) {        
        //objectManager.objects.setObjectOptions(e.get('objectId'),{preset: 'islands#greenDotIcon'});        
        $(".arrow-icon").removeClass("active-point");
        var ObjID = e.get('objectId');
        $(".arrow-icon#point-"+ObjID).addClass("active-point");

        var activeObj = objectManager.objects.getById(ObjID);

        var mCoord = activeObj.geometry.coordinates;
        myMap.setCenter(mCoord,16);

        var mTitle = activeObj.properties.hintContent;
        var mDescription = activeObj.options.description;
        var mYear = activeObj.options.year;
        var mImg = activeObj.options.img;
        fillPhotoBlock(mTitle, mDescription, mYear, mImg);
        fillModal(mTitle, mDescription, mYear, mImg);
    });
   
}

//фильтр меток по году ymaps
function SetFilterPoint(from, before) {            
    objectManager.setFilter( "options.year <= " + before + "&& options.year  >=" + from );
}

//фильтр меток по тегу ymaps
function SetFilterTags(tag) {
    objectManager.setFilter(function (obj) {       
        return obj.properties.tags.find(o => o === tag);
    });

    // var mCoord = objectManager.getBounds()[0];
    // myMap.setCenter(mCoord,15);
    //myMap.setBounds(objectManager.getBounds());    
}

//скрипт ползунка jquery ui - slider
$(function() {
    $("#slider-range").slider({
        range: true,
        min: YEAR_MIN,
        max: YEAR_MAX,
        values: [YEAR_MIN, YEAR_MAX],
        slide: function(event, ui) {
          $("#amount").val(ui.values[0] + " - " + ui.values[1] + " г.");
          SetFilterPoint(ui.values[0], ui.values[1]);
        }
    });
    $("#amount").val($("#slider-range").slider("values", 0) +
        " - " + $("#slider-range").slider("values",1) + " г.");
});

function fillPhotoBlock(mTitle, mDescription, mYear, mImg) {    
    $("#photo-block .pb-title").text(mTitle);
    $("#photo-block .pb-img").attr("src", mImg);
    $("#photo-block .pb-desrp").text(mDescription);
    $("#photo-block .badge-secondary").text(mYear+" год");    
}

function fillModal(mTitle, mDescription, mYear, mImg) {
    $("#showView .modal-title").text(mTitle);
    $("#showView .main-img").attr("src", mImg);
    $("#showView .desrp").text(mDescription);
    $("#showView .badge-secondary").text(mYear+" год");
}

$(document).ready(function() {
    document.onreadystatechange = function(){
        if(document.readyState === 'complete'){
            ObjID = POINT_FIRTS_ID;
            $(".arrow-icon#point-"+ObjID).addClass("active-point");            
        }
    }    

    $(".pb-img").on("click", function(){
        $('#showView').modal('show');
    });    

    $("#clear-tags").on("click", function(){
        SetFilterPoint(YEAR_MIN, YEAR_MAX);
        $("#tags").val("");
        resetSlider();
    });

    function resetSlider() {
        var $slider = $("#slider-range");
        $slider.slider("values", 0, YEAR_MIN);
        $slider.slider("values", 1, YEAR_MAX);
    }

    $('.ui-widget').on("focus","#tags",function(e) {
        $(this).autocomplete({           
            source:'/search_tags',
            select: displayItem
        });
    });

    function displayItem(event, ui) {      
       SetFilterTags(ui.item.label);
    }
});
