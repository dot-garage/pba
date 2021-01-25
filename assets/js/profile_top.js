$(function(){
   $(document).ready(colorbox);
   $(window).on('resize',colorbox);
   function colorbox() {
       var baseWidth = $(window).width();
       var w = baseWidth*0.8;
       var h = w*0.7;
   $(".youtube-modal1").colorbox({
       iframe:true,
       innerWidth: w,
       innerHeight: h,
       maxWidth: "90%"
   });
   };
});
