function go_drag()
{
    var obj = document.getElementById("img_team_show");
    if(obj == null) return 0;
    
    var clw = obj.getBoundingClientRect(); // Object from ViewPort // { x: 327.45001220703125, y: 43.600006103515625, width: 202, height: 202, top: 43.600006103515625, right: 529.4500122070312, bottom: 245.60000610351562, left: 327.45001220703125 }
    
    var offX = document.getElementById("offX");
    var offY = document.getElementById("offY");
    var imgWidth = document.getElementById("imgWidth");
    var imgHeigth = document.getElementById("imgHeigth");
    obj.style.backgroundSize = ( imgWidth.value + "px " + imgHeigth.value + "px" ) ; // w-px h-px

    var iX = 0;
    var iPrevX = 0;
    var iPrevY = 0;
    var startX = 0;
    var startY = 0;
    var striX = "";
    var striY = "";
    var down = false;
    
    obj.addEventListener("mousedown", function(ev)
    {
        down = true;

        // X
        if( iPrevX == NaN || iPrevX == 0 || iPrevX == undefined )
        {
            iPrev_X = 0;
        }
        else
        {
            iPrev_X = parseInt(iPrevX, 10);
        }
        startX = ( ev.clientX - clw.x );

        // Y
        if( iPrevY == NaN || iPrevY == 0 || iPrevY == undefined )
        {
            iPrev_Y = 0;
        }
        else
        {
            iPrev_Y = parseInt(iPrevY, 10);
        }
        startY = ( ev.clientY - clw.y );
    });

    obj.addEventListener("mousemove", function(e)
    {
        if( down )
        {
            iX = (e.clientX - clw.x) - startX; //
            striX = ( iX + iPrev_X ) + "px";
            obj.style.backgroundPositionX = striX;
            iPrevX = parseInt(obj.style.backgroundPositionX, 10); // Pass the postition X

            iY = (e.clientY - clw.y) - startY; //
            striY = ( iY + iPrev_Y ) + "px";
            obj.style.backgroundPositionY = striY;
            iPrevY = parseInt(obj.style.backgroundPositionY, 10); // Pass the postition Y
        }
    });

    obj.addEventListener("mouseup", function(ev)
    {
        down = false;
        obj.style.backgroundPositionX = striX;
        obj.style.backgroundPositionY = striY;

        offX.value = striX; // Pass through input hidden
    });
}
go_drag();