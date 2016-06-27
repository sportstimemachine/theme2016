( function( $ ) {

    function preload(arrayOfImages) {
        $(arrayOfImages).each(function(){
            $('<img/>')[0].src = wpData.themeDirectory + '/images/buttons2.png';
        });
    }

    $( document ).ready( function() {

        if($('#blContent').height() < 1350){
            $('#blContent').css('background-image','url(' + wpData.themeDirectory + '/images/bg2_short.png)');
        }
        else{
            $('#blContent').css('background-image','url(' + wpData.themeDirectory + '/images/bg2.png)');
        }	

        $('#blBody').append('<div id="bodyBottom"></div>');
        
        $('.modal').fancybox({
            'width' : 'auto',
            'height' : 'auto',
            'scrolling' : 'no'
        });

        if ( $( '.sponsor_form' ).length > 0 ) {

            $('.sponsor_form').submit( function( event ) {	
                
                event.preventDefault();
                
                $.ajax( {
                    type: 'POST',
                    url: $( this ).attr( 'action' ),
                    data: $( this ).serialize(),
                    success: function() {
                        $('.bl_form').html('<p style="font-size:16px;height:200px;text-align:center;">Thank you for your interest in sponsoring The Sports Time Machine! A member of our team will be in touch with you shortly to discuss the opportunities available.</p>');
                    },
                    error: function() {
                        $('.bl_form').html('<p style="font-size:16px;height:200px;text-align:center;">Something went wrong.</p>');
                    }
                } );
                
            } );

        }

        if ( $( '#fb-root' ).length > 0 ) {

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

        }

        if ( $( '[id*="jquery_jplayer_"]' ).length > 0 ) {

            $( '[id*="jquery_jplayer_"]' ).each( function( index, element ) {

                $( element ).jPlayer( {
                    cssSelectorAncestor: '#' + $( element ).next( '.jp-audio' ).attr( 'id' ),
                    play: function() { // To avoid both jPlayers playing together.
                        $( element ).jPlayer( "pauseOthers" );
                    },
                    ready: function ( event ) { 

                        $( element ).jPlayer( "setMedia", {
                            mp3: $( element ).data( 'file' ),
                        } );

                    },
                    swfPath: $( element ).data( 'swf' ),
                    supplied: "mp3",
                    wmode: "window"
                } );

            } );

        }

    } );

} )( jQuery );