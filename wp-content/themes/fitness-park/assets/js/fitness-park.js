jQuery(document).ready(function($){	
    /**
     * Repeater Fields
    */
    function fp_refresh_repeater_values(){
        $(".fp-repeater-field-control-wrap").each(function(){			
            var values = []; 
            var $this = $(this);			
            $this.find(".fp-repeater-field-control").each(function(){
            var valueToPush = {};
            $(this).find('[data-name]').each(function(){
                var dataName = $(this).attr('data-name');
                var dataValue = $(this).val();
                valueToPush[dataName] = dataValue;
            });
            values.push(valueToPush);
            });
            $this.next('.fp-repeater-collector').val(JSON.stringify(values)).trigger('change');
        });
    }

    $('#customize-theme-controls').on('click','.fp-repeater-field-title',function(){
        $(this).next().slideToggle();
        $(this).closest('.fp-repeater-field-control').toggleClass('expanded');
    });
    $('#customize-theme-controls').on('click', '.fp-repeater-field-close', function(){
        $(this).closest('.fp-repeater-fields').slideUp();;
        $(this).closest('.fp-repeater-field-control').toggleClass('expanded');
    });

    $("body").on("click",'.fp-add-control-field', function(){
        var $this = $(this).parent();
        if(typeof $this != 'undefined') {
            var field = $this.find(".fp-repeater-field-control:first").clone();
            if(typeof field != 'undefined'){                
                field.find("input[type='text'][data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });
                field.find("select[data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find(".fp-icon-list").each(function(){
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    var img_home_url= fitness_park_script.url_to_icon;
                    $(this).next('input[data-name]').val(defaultValue);
                    $(this).prev('.fp-selected-icon').children('img').attr('src',img_home_url+defaultValue).addClass(defaultValue);
                    
                    $(this).find('li').each(function(){
                        var icon_class = $(this).find('img').attr('class');
                        if(defaultValue == icon_class ){
                            $(this).addClass('icon-active');
                        }else{
                            $(this).removeClass('icon-active');
                        }
                    });
                });

                field.find(".fp-repeater-icon-list").each(function(){
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    $(this).prev('.fp-repeater-selected-icon').children('i').attr('class','').addClass(defaultValue);
                    
                    $(this).find('li').each(function(){
                        var icon_class = $(this).find('i').attr('class');
                        if(defaultValue == icon_class ){
                            $(this).addClass('icon-active');
                        }else{
                            $(this).removeClass('icon-active');
                        }
                    });
                });

                field.find(".attachment-media-view").each(function(){
                    var defaultValue = $(this).find('input[data-name]').attr('data-default');
                    $(this).find('input[data-name]').val(defaultValue);
                    if(defaultValue){
                        $(this).find(".thumbnail-image").html('<img src="'+defaultValue+'"/>').prev('.placeholder').addClass('hidden');
                    }else{
                        $(this).find(".thumbnail-image").html('').prev('.placeholder').removeClass('hidden');   
                    }
                });

                field.find('.fp-fields').show();

                $this.find('.fp-repeater-field-control-wrap').append(field);

                field.addClass('expanded').find('.fp-repeater-fields').show(); 
                $('.accordion-section-content').animate({ scrollTop: $this.height() }, 1000);
                fp_refresh_repeater_values();
            }

        }
        return false;
    });
	
    $("#customize-theme-controls").on("click", ".fp-repeater-field-remove",function(){
        if( typeof	$(this).parent() != 'undefined'){
            $(this).closest('.fp-repeater-field-control').slideUp('normal', function(){
                $(this).remove();
                fp_refresh_repeater_values();
            });			
        }
        return false;
    });

    $("#customize-theme-controls").on('keyup change', '[data-name]',function(){
        fp_refresh_repeater_values();
        return false;
    });

    $('body').on('click', '.fp-icon-list li', function(){
        var icon_class = $(this).find('img').attr('src');
        var icon_image = icon_class.split("/").pop();
        var img_home_url= fitness_park_script.url_to_icon;
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.fp-icon-list').prev('.fp-selected-icon').children('img').attr('src',img_home_url + icon_image).addClass(icon_class);
        $(this).parent('.fp-icon-list').next('input').val(icon_image).trigger('change');
        fp_refresh_repeater_values();
    });

    $('body').on('click', '.fp-selected-icon', function(){
        $(this).next().slideToggle();
    });

    /*Drag and drop to change order*/
    $(".fp-repeater-field-control-wrap").sortable({
        orientation: "vertical",
        update: function( event, ui ) {
            fp_refresh_repeater_values();
        }
    });

    $('body').on('click', '.fp-repeater-icon-list li', function(){
        var icon_class = $(this).find('i').attr('class');
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.fp-repeater-icon-list').prev('.fp-repeater-selected-icon').children('i').attr('class','').addClass(icon_class);
        $(this).parent('.fp-repeater-icon-list').next('input').val(icon_class).trigger('change');
        fp_refresh_repeater_values();
    });

    $('body').on('click', '.fp-repeater-selected-icon', function(){
        $(this).next().slideToggle();
    });

    /**
     * Select Multiple Category
    */
    $( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on( 'change', function() {

            var checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return $( this ).val();
                }
            ).get().join( ',' );

            $( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        
        }
    );

    /**
     * Multiple Gallery Image Control
    */
    $('.upload_gallery_button').click(function(event){
        var current_gallery = $( this ).closest( 'label' );

        if ( event.currentTarget.id === 'clear-gallery' ) {
            //remove value from input
            current_gallery.find( '.gallery_values' ).val( '' ).trigger( 'change' );

            //remove preview images
            current_gallery.find( '.gallery-screenshot' ).html( '' );
            return;
        }

        // Make sure the media gallery API exists
        if ( typeof wp === 'undefined' || !wp.media || !wp.media.gallery ) {
            return;
        }
        event.preventDefault();

        // Activate the media editor
        var val = current_gallery.find( '.gallery_values' ).val();
        var final;

        if ( !val ) {
            final = '[gallery ids="0"]';
        } else {
            final = '[gallery ids="' + val + '"]';
        }
        var frame = wp.media.gallery.edit( final );

        frame.state( 'gallery-edit' ).on(
            'update', function( selection ) {

                //clear screenshot div so we can append new selected images
                current_gallery.find( '.gallery-screenshot' ).html( '' );

                var element, preview_html = '', preview_img;
                var ids = selection.models.map(
                    function( e ) {
                        element = e.toJSON();
                        preview_img = typeof element.sizes.thumbnail !== 'undefined' ? element.sizes.thumbnail.url : element.url;
                        preview_html = "<div class='screen-thumb'><img src='" + preview_img + "'/></div>";
                        current_gallery.find( '.gallery-screenshot' ).append( preview_html );
                        return e.id;
                    }
                );

                current_gallery.find( '.gallery_values' ).val( ids.join( ',' ) ).trigger( 'change' );
            }
        );
        return false;
    });

    /*
    * Switch Enable/Disable Control.
    */
    $('body').on('click', '.onoffswitch', function(){
        var $this = $(this);
        if($this.hasClass('switch-on')){
            $(this).removeClass('switch-on');
            $this.next('input').val('disable').trigger('change')
        }else{
            $(this).addClass('switch-on');
            $this.next('input').val('enable').trigger('change')
        }
    }); 

    /**
     * Section re-order
    */
    $('#tm-sections-reorder').sortable({
        cursor: 'move',
        update: function(event, ui) {
            var section_ids = '';
            $('#tm-sections-reorder li').css('cursor','default').each(function() {
                var section_id = jQuery(this).attr( 'data-section-name' );
                section_ids = section_ids + section_id + ',';
            });
            $('#shortui-order').val(section_ids);
            $('#shortui-order').trigger('change');
        }
    });

    //Scroll to section
    $('body').on('click', '#sub-accordion-panel-fitness_park_homepage .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    });
    
});


function scrollToSection( section_id ){
	console.log(section_id);
    var preview_section_id = ".slider";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {

        case 'accordion-section-fitness_park_about_us':
        preview_section_id = ".introduction";
        break;

        case 'accordion-section-fitness_park_call_to_action':
        preview_section_id = ".offer";
        break;

        case 'accordion-section-fitness_park_service_section':
        preview_section_id = ".courses";
        break;

        case 'accordion-section-fitness_park_appointment':
        preview_section_id = ".video";
        break;

        case 'accordion-section-fitness_park_blog_posts':
        preview_section_id = ".fitness-park-blog-post-front";
        break;

        case 'accordion-section-fitness_park_gallery':
        preview_section_id = ".front-gallery";
        break;

        case 'accordion-section-fitness_park_testimonials':
        preview_section_id = ".trainers";
        break;
    }

    if( $contents.find(preview_section_id).length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( preview_section_id ).offset().top
        }, 1000);
    }
}
