(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.additional_blocks = {
        attach: function (context, settings) {
            // Isotope filtering
            var isotopeList = '';

            $('.isotope-filter-element').once('control').click( function(){
                // Check if element is active
                var tid = '.'+$(this).attr('data-isotope-filter');
                if ($(this).hasClass('active')) {
                    isotopeList = isotopeList.replace(tid, '');
                    $(this).removeClass('active');
                } else {
                    isotopeList = isotopeList+tid;
                    $(this).addClass('active');
                }
                //$('#isotope-instance-1').isotope('reLayout');
                // Get element width

                $('#isotope-instance-1')
                    .find('.isotope-grid-sizer')
                    .addClass('col-md-3 col-sm-12 col-xs-12')
                    .css('height', '300px');

                var cont = context;

                var inst = $(context).find('#isotope-instance-1');

                $('#isotope-instance-1').isotope({
                    filter: isotopeList,
                    layoutMode : 'fitRows',
                    masonry: {
                        columnWidth: '.isotope-grid-sizer'
                    }
                });
            });

            $('.isotope-filter').find('li').addClass('col-md-1 col-sm-2 col-xs-3');

            setTimeout(function(){ $('.isotope-filter').removeAttr('style').find('li').removeAttr('style'); }, 200);

            // Adding modals for facebook block
            //console.log('test'.drupalSettings);
            //alert('a');
            if (typeof drupalSettings.modals !== "undefined") {
                $('footer.footer').append(drupalSettings.modals);
            }
        }
    }
})(jQuery, Drupal, drupalSettings);