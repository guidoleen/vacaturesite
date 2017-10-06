jQuery(function($)
{
    // Event handlers
    $("#searchsubmit_").on("click", function()
    {
        var strTxt = $("#sa").val();
        if(strTxt != "")
        {
            ajax_search(strTxt);
        }
    });

    // Index search
    $("#searchsubmit_index").on("click", function()
    {
        // Overall URi
        strUriTotal = window.location.href + "vacatures?";
        var strArg = index_search();

        // if( strArg != "" ) strArg = strArg + "start=1"; // Not necesasary
        window.location.href = strUriTotal + strArg;
    });

    // Small Search function
    function ajax_search(str)
    {
        var loc = location.origin + sitename + "/lokaal";
        strUrl = loc + "/wp-content/themes/guidoleen/ajax/search_vac.php?vactxt=" + str; // decodeURIComponent(struri); href location.pathname 
        $.ajax({
            url: strUrl,
            type: "get",
            success: function(result)
            {
                try
                {
                    $("#search_div").html(result);
                }
                catch(e)
                {
                    "No sub search connection..."
                }
            }
        });
    }

    // Index page search
    var strUri = "";
    function index_search()
    {   
        // Abstract val from the google adress
        if( $('#indx_address').val() != "")
        {
            strUri += $('#indx_address').attr('ident') + "=";
            strUri += $('#indx_address').val() + "&";

            // Abstract the distance in km
            var objDist = $('.slct-menu[ident="dist"]').children('.indx-selct-distance').children('.slct-txt');
            if( objDist.attr('countr') == 1 && $('#indx_address').val() != "" )
            {
                strUri += "dist=";
                strUri += objDist.attr('val') + "&";
            }
        }

        // Abstract the val from the text input text
        var objTxt = $("#sea_text");
        if( objTxt.val() != "" )
        {
            strUri += "search=";
            strUri += objTxt.val() + "&";
        }
        return strUri;
    }

        iDist = 0;
        menu_ev_handle('.indx-selct-distance', iDist, "Y");

      // Function menu open/close event
      function menu_pop_down(strobj)
      {
          objthis = $(strobj); // $(this);
          obj = objthis.parent();
          strval = obj.attr('ident');
          strvalLi = "";

          if(objthis == null) return false;

          if( obj.children('ul').hasClass('hide') )
          {
              obj.children('ul').removeClass('hide');
              obj.children('ul').addClass('show');
          }
          else
          {
              obj.children('ul').removeClass('show');
              obj.children('ul').addClass('hide');
          }
      }

    // Function menu event
      function menu_ev_handle(strobj, iCount, CountYN)
      {
          $(strobj).on("click", function(event)
          {
              event.stopPropagation();
              menu_pop_down(strobj);
          });

          $(strobj).parent().children('ul').children('.slct-menu-li').on('click', function()
          {
              objLi = $(this);
              strtxtLi = objLi.text();
              strvalLi = objLi.attr('val');

                  objthis.children('.slct-txt').text(strtxtLi);
                  objthis.children('.slct-txt').attr('countr', 1);
                  objthis.children('.slct-txt').attr('val', strvalLi);

              obj.children('ul').removeClass('show');
              obj.children('ul').addClass('hide');
           });
      }

});

// Search close
function search_close(obj)
{
     objClose = document.getElementById(obj);
     objClose.classList.add('hide');
}