function go_drag()
{
    var obj = document.getElementById("img_team_show");
    if(obj == null) return 0;
    
    var clw = obj.getBoundingClientRect(); // Object from ViewPort // { x: 327.45001220703125, y: 43.600006103515625, width: 202, height: 202, top: 43.600006103515625, right: 529.4500122070312, bottom: 245.60000610351562, left: 327.45001220703125 }
    
    var offX = document.getElementById("offX");
    var offY = document.getElementById("offY");
    var imgWidth = document.getElementById("imgWidth");
    var imgHeigth = document.getElementById("imgHeigth");
    var rngPerc = document.getElementById("rngPerc");

    // obj.style.backgroundSize = ( imgWidth.value + "px " + imgHeigth.value + "px" ); // w-px h-px

    var iX = 0;
    var iPrevX = 0;
    var iPrevY = 0;
    var startX = 0;
    var startY = 0;
    var striX = "";
    var striY = "";
    var iPerc = 100;
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
        offY.value = striY; // Pass through input hidden
    });

    let iW = imgWidth.value;
    let iH = imgHeigth.value;
    var rngMove = function(e)
    {
        iPerc = ( e.target.value * 0.01 );

        imgWidth.value = iW * iPerc;
        imgHeigth.value = iH * iPerc;
        obj.style.backgroundSize = ( imgWidth.value + "px " + imgHeigth.value + "px" ) ;
    };
   rngPerc.addEventListener("mousedown", function(e)
   {
        rngMove(e);
        rngPerc.addEventListener("mousemove", function(ev)
        {
            rngMove(ev);
        });
   });
   rngPerc.addEventListener("mouseup", function(e)
   {
        rngPerc.removeEventListener("mousemove", rngMove);
   });
}
go_drag();

// Check the file name and pass it through
var objFile = document.getElementById("fileteam");
var objFileSubm = document.getElementById("subfileteam");
var objFnameSpan = document.getElementById("fname_span");
function fname_pass()
{
    objFnameSpan.innerHTML = objFile.files[0].name;
    objFileSubm.setAttribute("class", "button button-primary show");
}
objFile.addEventListener("change", fname_pass);

// After saving the file
var objPhoto = document.getElementById("img_team_show");
var objSave = document.getElementById("img_team_save");
var objAvatar = document.getElementById("img_team_avatar");
function fsave()
{
    if(objPhoto.style.backgroundImage != "") // if photo exists
    {
        objFileSubm.setAttribute("class", "button button-primary hide"); // hide the save again
        objSave.setAttribute("class", "show"); // Hide the div
        objAvatar.setAttribute("class", "show");
        
        objFnameSpan.setAttribute("class", "button button-primary button-green show"); // The upload button colorchange
        objFnameSpan.innerHTML = "Upload een andere foto..."; // The upload button

            objFile.addEventListener("change", avatar_hide);
    }
}
window.addEventListener("load", fsave);

function avatar_hide()
{
    objAvatar.setAttribute("class", "hide");
}

// * ADMIN PART * //
function shutiframe()
{
    var objContainIframe = document.getElementById("container_iframe_img");
    objContainIframe.style.display = "none";
}
function openiframe()
{
    var objContainIframe = document.getElementById("container_iframe_img");
    objContainIframe.style.width = "100%";
    objContainIframe.style.display = "block";
}


// TESTED //
// get uri params
// function getQueryParams(qs) 
// {
//     arrQ = qs.split("?");
//     if(arrQ == undefined) return "";

//     var arrPrms = arrQ[1]; // decodeURIComponent(arrQ[1]);
//     var strObj = {};
//     var iC = 0;
//     let val = "";
//     let key = "";
//     let strFLag = "";

//     for(let i = 0, n = arrPrms.length; i<n; i++)
//     {
//         if( arrPrms[i] == "=" )
//         {
//             i = i+1;
//             iC = 1;
//             (iC == 0) ? key = strFLag : val = strFLag;
//         }
        
//         if( arrPrms[i] == "&")
//         {
//             i = i+1;
//             iC = 0;
//             strObj.push( relateKeyVal(key, val) );

//             strFLag = "";
//             console.log(key + " " + val);
//         }
//         console.log(arrPrms[i]);
//         strFLag += arrPrms[i];
//     }
//     return strObj;
// }

// // Put together key val to the object
// function relateKeyVal(key, val)
// {
//     return eval(key) + ": " + val;
// }

// var query = getQueryParams(window.location.href);
// console.log(query);