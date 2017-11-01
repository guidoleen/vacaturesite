// Init this
var windw = null;
var obj = null;
var teamH = null;
var footr = null;

var title = null;
var funct = null;
var cont = null;
var email = null;
var url = null;

function init()
{
    obj = document.getElementById("team_info_membr"); // The grey Div
    teamH = document.getElementById("content-team"); // The team members
    footr = document.getElementById("main_footer"); // The Footer
    windw = window.innerHeight;
    contfootr = teamH.clientHeight + footr.clientHeight;
    // obj.style.minHeight = window.innerHeight;

    // Set the height for the grey back
    if( contfootr > windw )
    {
        obj.style.height = contfootr + "px";
    }
    else
    {
        obj.style.height = (windw - 100) + "px";
    }
    console.log(contfootr);
    title = document.getElementById("t_info_title");
    funct = document.getElementById("t_info_funct");
    cont = document.getElementById("t_info_cont");
    email = document.getElementById("t_info_email");
    url = document.getElementById("tmpUri").value + "/ajax/team_ajax.php";
}
window.addEventListener("load", init);
window.addEventListener("click", init);

// Check the divwidth
function obj_width()
{
    ( obj.style.width == "0px" ) ? obj.style.width = "100%" : obj.style.width = "0px";
}
// Shut/open the div
function shutdiv()
{
    obj_width();
}
document.getElementById("shutidiv").addEventListener("click", shutdiv);

// Get the info member
function see_infomember(id)
{
    // Set the proper height for the grey backgrnd
    obj_width();

    // Ajax call
    call_themember(id);
}
arrMem = document.getElementsByClassName("team-membr");
for(let i =0, n= arrMem.length; i<n; i++)
{
    arrMem[i].addEventListener("click", function(){
        see_infomember(arrMem[i].attributes.idmem.value); // get the idval from attr idem and call the ajaxservice
    });
}

// The ajaxcall
function call_themember(_id)
{
    var urlName = url;
    if(urlName == null) return null;

    var xH = new XMLHttpRequest();
    xH.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           // document.getElementById("demo").innerHTML = xH.responseText;

           title.innerHTML = _id;
           // funct.innerHTML = null;
           // cont.innerHTML = null;
           // email.innerHTML = null;
        }
    };
    xH.open("GET", urlName, true);
    xH.send();
}