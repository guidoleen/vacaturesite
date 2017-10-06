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
