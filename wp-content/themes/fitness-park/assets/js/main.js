jQuery(document).ready(function ($) {
    
    /**
     * Gallery Lightbox
     */
    $("a[rel^='prettyPhoto']").prettyPhoto({
        theme: 'light_rounded',
        slideshow: 5000,
        autoplay_slideshow: false,
        keyboard_shortcuts: true,
        deeplinking: false,
        default_width: 500,
        default_height: 344,
        social_tools: false,
        allow_resize: false
    });


    /**
     * Main Banner Slider
     */
    var owl = $('#main-slider');
    owl.owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    /**
     * Our Trainers
     */
    var trainers = $('#trainers-slider');
    trainers.owlCarousel({
        loop: true,
        margin: 10,
        autoplay: false,

        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    //Fired before current slide change
    owl.on('change.owl.carousel', function (event) {
        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-out]");
        setAnimation($elemsToanim, 'out');
    });

    // Fired after current slide has been changed
    var round = 0;
    owl.on('changed.owl.carousel', function (event) {

        var $currentItem = $('.owl-item', owl).eq(event.item.index);
        var $elemsToanim = $currentItem.find("[data-animation-in]");

        setAnimation($elemsToanim, 'in');
    })
    // add animate.css class(es) to the elements to be animated
    function setAnimation(_elem, _InOut) {
        // Store all animationend event name in a string.
        // cf animate.css documentation
        var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

        _elem.each(function () {
            var $elem = $(this);
            var $animationType = 'animated ' + $elem.data('animation-' + _InOut);

            $elem.addClass($animationType).one(animationEndEvent, function () {
                $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
            });
        });
    }



    /** sidebar mobile menu */
    $('body').click(function(evt){    
        //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
        if($(evt.target).closest('.cover-modal.active').length)
           return;             
 
       //Do processing of click event here for every element except with id menu_content
       if( $('body').hasClass('showing-menu-modal')){
            var body = document.body;
            
            $('.cover-modal.active').removeClass('active');
            body.classList.remove( 'showing-modal' );
            body.classList.add( 'hiding-modal' );
            body.classList.remove('showing-menu-modal');
            body.classList.remove('show-modal');

            document.documentElement.removeAttribute('style')


            // Remove the hiding class after a delay, when animations have been run.
            setTimeout( function() {
                body.classList.remove( 'hiding-modal' );
            }, 500 );
       }
       
    });


});


