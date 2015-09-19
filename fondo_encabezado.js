$(function(){//función para hacer dinamigo el fondo 
    
    var limit = 0; // 0 = infinite.
    var interval = 2;// Secs
    var images = [
        "imagenes/Fondos/1.jpg",
        "imagenes/Fondos/2.jpg",
        "imagenes/Fondos/3.jpg"
    ];

    var inde = 0; 
    var limitCount = 0;
    var myInterval = setInterval(function() {
       if (limit && limitCount >= limit-1) clearTimeout(myInterval);
       if (inde >= images.length) inde = 0;
        $('header').css({ "background-image":"url(" + images[inde]+ ")" });
       inde++;
       limitCount++;
    }, interval*5000);
});   