/**
 * 
 */
$(document).ready(function() {
    var imgConnect = 'images/connect.png';
    var imgDisconnect = 'images/disconnect.png';
    var timeoutValue = 10 * 1000;
    
    $.ajaxSetup({timeout : timeoutValue});
    
    function ajaxHeartbeatRequest(webserviceType) {
        if($('#'+webserviceType+'_img').length > 0) {
            $.ajax({
                url     : 'wsHeartbeat.php',
                data    : {'webservice' : webserviceType},
                success : function(data) {
                    if(data == 'true') {
                        $('#'+webserviceType+'_img').attr('src', imgConnect);
                        $('#'+webserviceType+'_img').attr('title', 'The webservice is connected.');
                    }
                    else {
                        $('#'+webserviceType+'_img').attr('src', imgDisconnect);
                        $('#'+webserviceType+'_img').attr('title', 'The webservice is disconnected.');
                    }
                },
                error   : function(xhr, text, error) {
                    $('#'+webserviceType+'_img').attr('src', imgDisconnect);
                    
                    if(text == 'timeout') {
                        $('#'+webserviceType+'_img').attr('title', 'The webservice couldn\'t be reached within ' + timeoutValue / 1000 + ' seconds.');
                    }
                    else {
                        $('#'+webserviceType+'_img').attr('title', 'The webservice connection is currently down.');
                    }
                }
            });
        }
    }
    
    ajaxHeartbeatRequest('ws3_0');
});
