/*----------------------------------------------------*/
/*  Quantity Buttons with Total Value Counter
/*
/*  Author: Vasterad
/*  Version: 1.0
/*----------------------------------------------------*/

jQuery(document).ready(function($) {

   function qtySum(){
      var arr = document.getElementsByName('qtyInput');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
  
      var cardQty = $(".qtyTotal");
      cardQty.html(tot);
  } 
  qtySum();

   $(".qtyButtons input").after('<div class="qtyInc"></div>');
   $(".qtyButtons input").before('<div class="qtyDec"></div>');

   $(".qtyDec, .qtyInc").on("click", function() {
      
      var $button = $(this);
      var oldValue = $button.parent().find("input").val();
      var max = $button.parent().find("input").data('max');

      if ($button.hasClass('qtyInc')) {
         if(max){
            if (oldValue < max) {
               var newVal = parseFloat(oldValue) + 1;   
            } else {
               newVal = oldValue;
            }
         } else {
            var newVal = parseFloat(oldValue) + 1;   
         }
         
      } else {
         // don't allow decrementing below zero
         if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 1;
         } else {
            newVal = 1;
         }
      }


      $button.parent().find("input").val(newVal).trigger('change');;
      qtySum();
      $(".qtyTotal").addClass("rotate-x");

   });

   // Total Value Counter Animation
   function removeAnimation() { $(".qtyTotal").removeClass("rotate-x"); }

   const counter = $(".qtyTotal");
   counter.on("animationend", removeAnimation);
   // Adjusting Panel Dropdown Width
   $(window).on('load resize', function() {
      var panelTrigger = $('.booking-widget .panel-dropdown a');
      $('.booking-widget .panel-dropdown .panel-dropdown-content').css({
         'width' : panelTrigger.outerWidth()
      });
   });

});
