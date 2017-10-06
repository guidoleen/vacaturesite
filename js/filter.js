var sitename = "/guido"; // MUST BE CHANGED !!!!!!
var strUri = "";
var iPagenr = 0;
var iSlctCount = 0; // When i want to show filter results or starting page
var iCHref = 0; // Indexer for Fire once from indexpage > filterpage

// Overall function withe the document.ready
function init()
{
    strUri = "";

    jQuery(function($)
    {
        // OVERALL FUNCTIONS/EVENTS
        // Function hide all menu items
        $("html").on('click', function()
        {
            // menu_pop_down('.selct-distance');
            $('.slct-menu-ul ').removeClass('show');
            $('.slct-menu-ul ').addClass('hide');
        });

        // EVENT HANDLERS FOR AJAX CALL (FILTER)
        // MENU Event handlers for pop menu 
        iDist = 0;
        menu_ev_handle('.selct-distance', iDist, "Y");

        iVakg = 0;
        menu_ev_handle('.slct-vakgeb', iVakg, "Y");

        iAscdesc = 0;
        menu_ev_handle('.selct-ascdesc', iAscdesc, "N");

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
  
                      if( objthis.children('.slct-txt').attr('countr') == 1 ) // OLD // $('select[class="selct-distance"]').on('change', function()
                      {
                          iCount++;
                          if(iCount == 1 && CountYN == "Y")
                          {
                              selct_count(true); // The function adds up when filtering is used....
                          }
                      }
                      iPagenr = 0;
                      filter_ui( objthis, 0, 1, iPagenr );
  
                  obj.children('ul').removeClass('show');
                  obj.children('ul').addClass('hide');
               });
          }
        // End pop menu handler

        $('input[type="checkbox"]').on('click', function() 
        { 
            selct_count(this.checked);

            iPagenr = 0;
            filter_ui( $(this), 1, 1, iPagenr );
         });
        

        $('select[class="slct-asc-desc"]').change(function() 
        { 
            filter_ui($(this), 0, 1, iPagenr );
        });

        // Range slider
        var rngVal = 0;
        var rngFactr = 75;
        $("#rng-salaris").change(function()
        {
            $objrng = $(this);
            rngVal = range_val( $objrng.val(), rngFactr );
            $(".rng-val").text(rngVal);
            $objrng.on('mousemove', function()
            {
                ngVal = range_val( $objrng.val(), rngFactr );
                $(".rng-val").text(rngVal);
            });

            $objrng.on('mouseup', function() // Call the filter
            {
                rngVal = range_val( $objrng.val(), rngFactr );
                $(".rng-val").text( rngVal );
            });
        });

        // rangevalidation
        function range_val(iIn, iFactr)
        {
            return iIn * iFactr;
        }

/////   Pager event
        $('.vac-page').on( 'click', function()
        { 
            iPagenr = $(this).attr('pager'); 

            filter_ui( $(this), '', iSlctCount, iPagenr );
        }); 
//////

/////   Clear filter Event
        function clear_filter()
        {
            $("#closefilter").on("click", function()
            {
                // Afstand...
                $('#address').val("");
                var objDistCl = $('.slct-menu[ident="dist"]').children('.selct-distance').children('.slct-txt');
                objDistCl.text("Afstand...");
                objDistCl.attr('val', "");
                objDistCl.attr('countr', "0");

                // Checkbox...
                $('#sidebar-filtr').children('ul').children('li').children('div').children('input').each( function()
                {
                    if( $(this).attr('selc') == 1  )
                    {
                        $(this).attr('selc', 0);
                        $(this).prop('checked', '');
                    }  
                });

                // List selector
                var selObjCl = $('.slct-menu[ident="vakgeb"]').children('.slct-vakgeb').children('.slct-txt');
                selObjCl.attr('val', '');
                selObjCl.text('Selecteer...');

                iSlctCount=0; // Set start to zero again

                iPagenr = 0;
                iCHref = -1; // The indexpage indexer

                filter_ui( $(this), 1, 1, iPagenr );
            });
        }
        // Call function clear filter
        clear_filter();
/////

        if(iSlctCount == 0) filter_ui($(this), 0, 0, iPagenr );
            // $("body").ready(function() {filter_ui($(this), 0, 0 ) } ); // First time load or when selections are off

        // BEGIN FILTER //
        // Filtering the values
        function filter_ui(_obj, _selct, _filter, _iPagenr)
        {
            // String query URI
            strUri = "";

            if(_filter == 0) iSlctCount = 0;
                
            var obj = _obj;
            
            // If object already was selected....
            if(_selct == 1)
            {
                ( obj.attr('selc') == 1 ) ? obj.attr('selc', 0) : obj.attr('selc', 1);
            }

            // Abstract val from the google adress
            if( $('#address').val() !== "")
            {
                strUri += $('#address').attr('ident') + "=";
                strUri += $('#address').val() + "&";

                // Abstract the distance in km
                var objDist = $('.slct-menu[ident="dist"]').children('.selct-distance').children('.slct-txt');
                if( objDist.attr('countr') == 1 && $('#address').val() != "" )
                {
                    strUri += "dist=";
                    strUri += objDist.attr('val') + "&";
                }
            }
            else
            {
                // iSlctCount = 0;
            }

            // Abstract the val from selected
            $('#sidebar-filtr').children('ul').children('li').children('div').children('input').each( function()
            {
                if( $(this).attr('selc') == 1  )
                {
                    strUri += $(this).attr('ident') + "=";
                    strUri += $(this).val() + "&";
                }  
            });

            // Abstract the val from the optionlist vakgebied
            var selObj = $('.slct-menu[ident="vakgeb"]').children('.slct-vakgeb').children('.slct-txt');
            if( selObj.attr('val') != 0)
            {
                strUri += "vakgeb=";
                strUri += selObj.attr('val') + "&";
            }

            // Abstract the val from indexpage through the locationhref
            // ?googl=Amsterdam&search=C#&start=1
            iCHref = iCHref + 1;
            if( iCHref > 0 && $('#address').val() === "" )
            {
                var arrHref = window.location.href.split("?");
                if(arrHref.length > 1)
                {
                    if( iCHref == 1 ) selct_count(true); // Set the start position to 1 just once
                    try
                    {
                        arrHref = arrHref[1].split("/");
                        arrHref = arrHref[0].split("&");
                        for(var arr in arrHref)
                        {
                            strUri += encodeURI( arrHref[arr] ) + "&"; // .split("=")[1];
                        }
                    }
                    catch(exception)
                    {
                        document.write(exception);
                    }
                }
            }

            // Abstract the asc or desc val from option
            var selDesc = $('.slct-menu[ident="asc_desc"]').children('.selct-ascdesc').children('.slct-txt');
            if( selDesc.attr('val') != 0)
            {
                strUri += "asc_desc=";
                strUri += selDesc.attr('val') + "&";
            }

            // Set the starting point YN
                strUri += 'start=' + iSlctCount + "&";

            // Call the filter and change val inside vacatures
            filter_ajax($('#vacatures'), strUri, _iPagenr);

            // create new pager based on search criteria
        }
        // END FILTER // // function filter_ajax(obj, strUri, iPagenr); // OLD PLACE
    });
}
init(); // call the OVERALL function first time

// PAGER function 
var strURI = "";
function page_nr(_pn)
{
    strURI = strURI.substring(0, strURI.length-1) + _pn;
    filter_ajax( document.getElementById('vacatures'), strURI, _pn); // Call the ajax function
}

// Function selection counter for the start or query part
function selct_count(YN)
{
    if(YN == true)
    {
        iSlctCount = iSlctCount+1;
    }
    else
    {
        iSlctCount = iSlctCount-1;
    }
}

// AJAX function
function filter_ajax(obj, strUri, iPagenr)
{
    jQuery(function($)
    {
        strPage = "";

        // Abstract the page no
        // iPagenr = document.getElementById('page-nr').value;
        strPage += '&page' + "=";
        strPage += iPagenr; // + "&";

        _strUri = strUri.substring(0, strUri.length-1) + strPage;
        struri = _strUri;

        console.log(struri);

            var loc = location.origin + sitename + "/lokaal";
            var strTotal = "";
            strUrl = loc + "/wp-content/themes/guidoleen/ajax/filter.php?" + struri; // decodeURIComponent(struri); href location.pathname 
            $.ajax({
                url: strUrl,
                type: "get",
                success: function(result)
                {
                    try
                    {
                        if(result == false)
                        {
                            // obj.html(result);
                            // window.location.href = loc; // Back to the index page
                        }
                        obj.innerHTML = result; // Show the result as post array items second time
                        obj.html(result); // Show the result as post array items first time

                        strURI = struri; // for passing the URI string in global var
                    }
                    catch(e)
                    {
                        // Error
                    }
                }
            });
    });
}
