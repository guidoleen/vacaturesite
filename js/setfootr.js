// Function set Footer in the right position
function set_footer()
{
    var ipH = document.getElementById("page").clientHeight; // $("#page").width();
    var iwH = window.innerHeight;
    var objF = document.getElementById("main_footer"); // var objF = document.getElementsByTagName("footer");
    
    if(ipH > iwH)
    {
        objF.style = "position: relative;";
    }
    else
    {
        objF.style = "position: absolute;";
    }
}
setTimeout(function(){set_footer();}, 500);