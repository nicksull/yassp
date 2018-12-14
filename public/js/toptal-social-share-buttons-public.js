(function( $ ) {
	'use strict';

  $(document).ready(function() {

    // Open sized popup window on desktop
    $('.toptal-share-btn a').on('click', function(e) {
      e.preventDefault();
      window.open($(this).attr('href'),'title', 'width=600, height=500');
      return false;
    });

  });

})( jQuery );
