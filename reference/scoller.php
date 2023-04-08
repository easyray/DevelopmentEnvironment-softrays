<script>
/*You should use j-Query, as you cannot use this plug-in alone.
Also you should do the   following includes:
jquery.mCustomScrollbar.min.css
jquery.mousewheel.min.js
jquery.mCustomScrollbar.min.js
Your first instance of the scroll should be done when the document is ready.
*/

    (function($){
        $(window).load(function(){
            $("#product-listview").mCustomScrollbar({ autoHideScrollbar: true});
            $("#product-listview .mCSB_container").get(0).style.marginRight = "0px";
        });
    })(jQuery);

/*
Note that the plug-in encloses your container with a series of divs, the innermost being a div with a class called “mCSB_container”; this usually has an annoying right margin that you may wish to remove.
If you need to empty your div and rebuild it then I found it helps to destroy the whole scroll thing and start it afresh.
*/
(function($){
  $("#product-listview").mCustomScrollbar("destroy");
 })(jQuery);
//---------------------
(function($){
   $("#product-listview").mCustomScrollbar({ autoHideScrollbar: true});
})(jQuery);
</script>