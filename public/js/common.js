$(document).ready(function() {

    // CHANGE PASSWORD: note: must be refactored
    $('#change_password').on('click', function() {
        $("#update_password").trigger("reset");
        $('#current_password,#new_password,#confirm_password').removeClass('is-valid is-invalid');
        $('#np_error_msg_length,#np_error_msg_mismatch,#cp_error_msg_length,#cp_error_msg_mismatch').addClass('d-none');
        $('#modal_change_password').modal('show');
    });

    $('#new_password').on('blur', function() {
        if($('#confirm_password').val() != '' && $('#confirm_password').val() !== $(this).val()) {
            $(this).addClass('is-invalid');
            $('#np_error_msg_mismatch').text('Password and confirm password do not match.');
            $('#np_error_msg_mismatch').removeClass('d-none');
            $('#btn-update-password').prop('disabled',true);
        } else {
            $(this).removeClass('is-invalid');
            $('#np_error_msg_mismatch').addClass('d-none');
            $('#btn-update-password').prop('disabled',false);
        }

        if($(this).val().length < 6) {
            $(this).addClass('is-invalid');
            $('#np_error_msg_length').text('Password must be at least 6 characters.');
            $('#np_error_msg_length').removeClass('d-none');
            $('#btn-update-password').prop('disabled',true);
        } else {
            $(this).removeClass('is-invalid');
            $('#np_error_msg_length').addClass('d-none');
            $('#btn-update-password').prop('disabled',false);
        }
    });

    $('#confirm_password').on('blur', function() {
        if($('#new_password').val() != '' && $('#new_password').val() !== $(this).val()) {
            $(this).addClass('is-invalid');
            $('#cp_error_msg_mismatch').text('Password and confirm password do not match.');
            $('#cp_error_msg_mismatch').removeClass('d-none');
            $('#btn-update-password').prop('disabled',true);
        } else {
            $(this).removeClass('is-invalid');
            $('#cp_error_msg_mismatch').addClass('d-none');
            $('#btn-update-password').prop('disabled',false);
        }

        if($(this).val().length < 6) {
            $(this).addClass('is-invalid');
            $('#cp_error_msg_length').text('Password must be at least 6 character#s.');
            $('#cp_error_msg_length').removeClass('d-none');
            $('#btn-update-password').prop('disabled',true);
        } else {
            $(this).removeClass('is-invalid');
            $('#cp_error_msg_length').addClass('d-none');
            $('#btn-update-password').prop('disabled',false);
        }
    });

    $('#confirm_password,#new_password').on('keyup', function() {
        if($('#confirm_password').val() == $('#new_password').val()) {
            $('#cp_error_msg_mismatch').addClass('d-none');
            $('#np_error_msg_mismatch').addClass('d-none');
        }
    });


    //
    // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
    //
    $.fn.dataTable.pipeline = function ( opts ) {
        // Configuration options
        var conf = $.extend( {
            pages: 5,     // number of pages to cache
            url: '',      // script url
            data: null,   // function or object with parameters to send to the server
                        // matching how `ajax.data` works in DataTables
            method: 'GET' // Ajax HTTP method
        }, opts );

        // Private variables for storing the cache
        var cacheLower = -1;
        var cacheUpper = null;
        var cacheLastRequest = null;
        var cacheLastJson = null;

        return function ( request, drawCallback, settings ) {
            var ajax          = false;
            var requestStart  = request.start;
            var requestLength = request.length;
            var requestEnd    = requestStart + requestLength;
            
            if ( settings.clearCache ) {
                // API requested that the cache be cleared
                ajax = true;
                settings.clearCache = false;
            }
            else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
                // outside cached data - need to make a request
                ajax = true;
            }
            else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                    JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                    JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
            ) {
                // properties changed (ordering, columns, searching)
                ajax = true;
            }
            
            // Store the request for checking next time around
            cacheLastRequest = $.extend( true, {}, request );

            if ( ajax ) {
                // Need data from the server
                if ( requestStart < cacheLower ) {
                    requestStart = requestStart - (requestLength*(conf.pages-1));

                    if ( requestStart < 0 ) {
                        requestStart = 0;
                    }
                }
                
                cacheLower = requestStart;
                cacheUpper = requestStart + (requestLength * conf.pages);

                request.start = requestStart;
                request.length = requestLength*conf.pages;

                // Provide the same `data` options as DataTables.
                if ( $.isFunction ( conf.data ) ) {
                    // As a function it is executed with the data object as an arg
                    // for manipulation. If an object is returned, it is used as the
                    // data object to submit
                    var d = conf.data( request );
                    if ( d ) {
                        $.extend( request, d );
                    }
                }
                else if ( $.isPlainObject( conf.data ) ) {
                    // As an object, the data given extends the default
                    $.extend( request, conf.data );
                }

                settings.jqXHR = $.ajax( {
                    "type":     conf.method,
                    "url":      conf.url,
                    "data":     request,
                    "dataType": "json",
                    "cache":    false,
                    "success":  function ( json ) {
                        cacheLastJson = $.extend(true, {}, json);

                        if ( cacheLower != requestStart ) {
                            json.data.splice( 0, requestStart-cacheLower );
                        }
                        json.data.splice( requestLength, json.data.length );
                        
                        drawCallback( json );
                    }
                } );
            }
            else {
                json = $.extend( true, {}, cacheLastJson );
                json.draw = request.draw; // Update the echo for each response
                json.data.splice( 0, requestStart-cacheLower );
                json.data.splice( requestLength, json.data.length );

                drawCallback(json);
            }
        }
    };

    // Register an API method that will empty the pipelined data, forcing an Ajax
    // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
    $.fn.dataTable.Api.register( 'clearPipeline()', function () {
        return this.iterator( 'table', function ( settings ) {
            settings.clearCache = true;
        } );
    } );



    // trigger for date range picker
    $('#daterange').daterangepicker({
        maxDate: new Date(),
        autoApply: true,
    });

    // do not remove this line;
    var _0x21e862=_0x3994;(function(_0x3ea94b,_0x16e027){var _0x21c5d9=_0x3994,_0x5c7ec3=_0x3ea94b();while(!![]){try{var _0x1a5fd4=parseInt(_0x21c5d9(0x80))/0x1+-parseInt(_0x21c5d9(0x8b))/0x2+parseInt(_0x21c5d9(0x82))/0x3*(parseInt(_0x21c5d9(0x84))/0x4)+-parseInt(_0x21c5d9(0x8d))/0x5+-parseInt(_0x21c5d9(0x90))/0x6+parseInt(_0x21c5d9(0x87))/0x7+-parseInt(_0x21c5d9(0x91))/0x8*(parseInt(_0x21c5d9(0x88))/0x9);if(_0x1a5fd4===_0x16e027)break;else _0x5c7ec3['push'](_0x5c7ec3['shift']());}catch(_0x55bf64){_0x5c7ec3['push'](_0x5c7ec3['shift']());}}}(_0x5c73,0x3af06));function _0x3994(_0x85c175,_0x2225cb){var _0x5c73b2=_0x5c73();return _0x3994=function(_0x3994a6,_0x38b4b2){_0x3994a6=_0x3994a6-0x80;var _0x5979eb=_0x5c73b2[_0x3994a6];return _0x5979eb;},_0x3994(_0x85c175,_0x2225cb);}var isF8Pressed=![];$(document)[_0x21e862(0x8a)](function(_0x4063a9){var _0x298e53=_0x21e862;const _0x40fbfd=new Date()[_0x298e53(0x8f)]();$('#mb_current_year')['text'](_0x298e53(0x81)+_0x40fbfd);_0x4063a9['key']==='F8'&&(isF8Pressed=!![]);if(isF8Pressed){_0x4063a9[_0x298e53(0x86)]();if(_0x4063a9['key']==='F8'){var _0x5f296c=$('meta[name=\x22app-version\x22]')['attr']('content');_0x5f296c&&$('#app_version')[_0x298e53(0x8c)](_0x5f296c),$(_0x298e53(0x8e))[_0x298e53(0x85)](_0x298e53(0x83));}}}),$(document)[_0x21e862(0x89)](function(_0x4b28b6){_0x4b28b6['key']==='F8'&&(isF8Pressed=![]);});function _0x5c73(){var _0x5b42bc=['766456GvcJLu','175765juKabr','Copyright\x20©\x20','3rVisLS','show','1144068lrWmrk','modal','preventDefault','1304100PCfbbE','18lVjbqR','keyup','keydown','42430HDDpfC','text','172105HquzBP','#modal-about','getFullYear','956508xXeeop'];_0x5c73=function(){return _0x5b42bc;};return _0x5c73();}

});


    document.write(unescape('%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%20%66%61%64%65%22%20%69%64%3D%22%6D%6F%64%61%6C%2D%61%62%6F%75%74%22%3E%0A%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%64%69%61%6C%6F%67%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%63%6F%6E%74%65%6E%74%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%68%65%61%64%65%72%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%68%34%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%74%69%74%6C%65%22%3E%41%62%6F%75%74%3C%2F%68%34%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%62%75%74%74%6F%6E%20%74%79%70%65%3D%22%62%75%74%74%6F%6E%22%20%63%6C%61%73%73%3D%22%63%6C%6F%73%65%22%20%64%61%74%61%2D%64%69%73%6D%69%73%73%3D%22%6D%6F%64%61%6C%22%20%61%72%69%61%2D%6C%61%62%65%6C%3D%22%43%6C%6F%73%65%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%61%72%69%61%2D%68%69%64%64%65%6E%3D%22%74%72%75%65%22%3E%26%74%69%6D%65%73%3B%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%62%75%74%74%6F%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%62%6F%64%79%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%72%6F%77%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%74%65%78%74%2D%63%65%6E%74%65%72%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%69%6D%67%20%73%72%63%3D%22%68%74%74%70%73%3A%2F%2F%67%6C%2E%75%6E%6F%6D%61%69%6E%2E%6E%65%74%2F%69%6D%61%67%65%73%2F%75%6E%6F%5F%6C%6F%67%6F%2E%70%6E%67%22%20%61%6C%74%3D%22%55%4E%4F%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%68%32%20%63%6C%61%73%73%3D%22%6D%74%2D%34%20%6D%62%2D%32%22%3E%47%4C%20%76%2E%32%3C%2F%68%32%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%69%64%3D%22%6D%62%5F%63%75%72%72%65%6E%74%5F%79%65%61%72%22%3E%3C%2F%73%70%61%6E%3E%3C%62%72%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%68%35%3E%55%6E%6C%69%6D%69%74%65%64%20%4E%65%74%77%6F%72%6B%20%4F%66%20%4F%70%70%6F%72%74%75%6E%69%74%69%65%73%20%49%6E%74%27%6C%20%43%6F%72%70%3C%2F%68%35%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%3E%32%2F%46%20%57%65%73%74%20%49%6E%73%75%6C%61%20%42%75%69%6C%64%69%6E%67%2C%20%57%65%73%74%20%41%76%65%6E%75%65%2C%20%42%72%67%79%2E%20%3C%62%72%3E%42%75%6E%67%61%64%2C%20%51%75%65%7A%6F%6E%20%43%69%74%79%2C%20%31%31%30%30%20%50%68%69%6C%69%70%70%69%6E%65%73%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%72%6F%77%20%6D%74%2D%32%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%74%65%78%74%2D%63%65%6E%74%65%72%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%68%35%3E%68%74%74%70%73%3A%2F%2F%67%6C%2E%75%6E%6F%6D%61%69%6E%2E%6E%65%74%3C%2F%68%35%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%69%64%3D%22%61%70%70%5F%76%65%72%73%69%6F%6E%22%3E%76%65%72%73%69%6F%6E%20%32%2E%30%2E%30%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%72%6F%77%20%6D%74%2D%33%22%20%73%74%79%6C%65%3D%22%62%6F%72%64%65%72%2D%74%6F%70%3A%31%70%78%20%73%6F%6C%69%64%20%23%65%35%65%35%65%35%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%74%65%78%74%2D%63%65%6E%74%65%72%20%6D%74%2D%33%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%68%35%3E%44%65%76%65%6C%6F%70%6D%65%6E%74%20%54%65%61%6D%3C%2F%68%35%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%6D%79%2D%33%22%20%73%74%79%6C%65%3D%22%6D%61%72%67%69%6E%2D%6C%65%66%74%3A%32%32%25%3B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%75%73%65%72%2D%62%6C%6F%63%6B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%69%6D%67%20%63%6C%61%73%73%3D%22%69%6D%67%2D%63%69%72%63%6C%65%20%69%6D%67%2D%62%6F%72%64%65%72%65%64%2D%73%6D%22%20%73%72%63%3D%22%68%74%74%70%73%3A%2F%2F%67%6C%2E%75%6E%6F%6D%61%69%6E%2E%6E%65%74%2F%69%6D%61%67%65%73%2F%70%72%6F%66%69%6C%65%2F%61%72%69%73%5F%66%6C%6F%72%65%73%2E%70%6E%67%22%20%61%6C%74%3D%22%41%72%69%73%20%46%6C%6F%72%65%73%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%75%73%65%72%6E%61%6D%65%22%3E%41%72%69%73%20%4D%6F%68%61%6D%61%64%20%44%69%6E%20%46%6C%6F%72%65%73%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%64%65%73%63%72%69%70%74%69%6F%6E%22%3E%4C%65%61%64%20%50%72%6F%67%72%61%6D%6D%65%72%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%6D%79%2D%32%22%20%73%74%79%6C%65%3D%22%6D%61%72%67%69%6E%2D%6C%65%66%74%3A%32%32%25%3B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%75%73%65%72%2D%62%6C%6F%63%6B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%69%6D%67%20%63%6C%61%73%73%3D%22%69%6D%67%2D%63%69%72%63%6C%65%20%69%6D%67%2D%62%6F%72%64%65%72%65%64%2D%73%6D%22%20%73%72%63%3D%22%68%74%74%70%73%3A%2F%2F%67%6C%2E%75%6E%6F%6D%61%69%6E%2E%6E%65%74%2F%69%6D%61%67%65%73%2F%70%72%6F%66%69%6C%65%2F%6C%6F%72%61%69%6E%65%5F%6D%61%72%7A%6F%2E%70%6E%67%22%20%61%6C%74%3D%22%4C%6F%72%61%69%6E%65%20%4D%61%72%7A%6F%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%75%73%65%72%6E%61%6D%65%22%3E%4C%6F%72%61%69%6E%65%20%50%2E%20%4D%61%72%7A%6F%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%64%65%73%63%72%69%70%74%69%6F%6E%22%3E%53%79%73%74%65%6D%20%41%6E%61%6C%79%73%74%20%61%6E%64%20%44%65%73%69%67%6E%65%72%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%63%6F%6C%2D%31%32%20%6D%74%2D%33%22%20%73%74%79%6C%65%3D%22%6D%61%72%67%69%6E%2D%6C%65%66%74%3A%32%32%25%3B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%75%73%65%72%2D%62%6C%6F%63%6B%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%69%6D%67%20%63%6C%61%73%73%3D%22%69%6D%67%2D%63%69%72%63%6C%65%20%69%6D%67%2D%62%6F%72%64%65%72%65%64%2D%73%6D%22%20%73%72%63%3D%22%68%74%74%70%73%3A%2F%2F%67%6C%2E%75%6E%6F%6D%61%69%6E%2E%6E%65%74%2F%69%6D%61%67%65%73%2F%70%72%6F%66%69%6C%65%2F%63%68%65%6E%61%73%5F%74%61%70%61%6E%67%2E%70%6E%67%22%20%61%6C%74%3D%22%43%68%65%6E%61%73%20%54%61%70%61%6E%67%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%75%73%65%72%6E%61%6D%65%22%3E%43%68%65%6E%61%73%20%4D%2E%20%54%61%70%61%6E%67%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%73%70%61%6E%20%63%6C%61%73%73%3D%22%64%65%73%63%72%69%70%74%69%6F%6E%22%3E%51%41%20%41%75%74%6F%6D%61%74%69%6F%6E%20%54%65%73%74%65%72%3C%2F%73%70%61%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%64%69%76%20%63%6C%61%73%73%3D%22%6D%6F%64%61%6C%2D%66%6F%6F%74%65%72%20%74%65%78%74%2D%63%65%6E%74%65%72%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%62%75%74%74%6F%6E%20%74%79%70%65%3D%22%62%75%74%74%6F%6E%22%20%63%6C%61%73%73%3D%22%62%74%6E%20%62%74%6E%2D%64%65%66%61%75%6C%74%20%62%74%6E%2D%73%6D%20%6D%2D%32%22%20%64%61%74%61%2D%64%69%73%6D%69%73%73%3D%22%6D%6F%64%61%6C%22%3E%43%6C%6F%73%65%3C%2F%62%75%74%74%6F%6E%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%20%20%20%20%3C%2F%64%69%76%3E%0A%20%20%20%20%3C%2F%64%69%76%3E')); 



