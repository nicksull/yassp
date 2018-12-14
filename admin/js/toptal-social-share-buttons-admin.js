(function( $ ) {
	'use strict';

   $(document).ready(function() {

     // Apply wordpress colour picker to colour field
     $('.toptal-social-share-buttons-colour').wpColorPicker();

     // Show/hide colour picker if custom colour checkbox is checked/unchecked
     $('#toptal-social-share-buttons-custom_colour').change(function() {
       $('#colour-picker').toggleClass('hidden');
     });

     // jQuery sortable
     $('ul.sortable').sortable({
       'tolerance':'intersect',
       'items':'li',
       create: function (event, ui) {
         // Create array of list order
         var data = $(this).sortable('toArray');
         // Set hidden field to initial order
         $('#toptal-social-share-buttons-order').val(data);

       },
       update: function (event, ui) {
         // Create array of list order
         var data = $(this).sortable('toArray');
         // Set hidden field to updated order
         $('#toptal-social-share-buttons-order').val(data);

       }

     });

    });

})( jQuery );
