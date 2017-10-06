// Function set Footer in the right position
function set_footer()
{
    var ipH = document.getElementById("page").clientHeight; // $("#page").width();
    var iwH = window.innerHeight;
    var objF = document.getElementsByTagName("footer");
console.log(ipH);
    if(ipH > iwH)
    {
        objF[0].style = "position: relative;";
    }
    else
    {
        objF[0].style = "position: absolute;";
    }
}
setTimeout(function(){set_footer();}, 500);