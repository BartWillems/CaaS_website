$( document ).ready(function() {

    //Load port range
    getPortRange();

    $('#setPortRangeBtn').click(function(){
        var beginPort = $('#begin_port').val();
        var endPort = $('#end_port').val();
        if(beginPort > 1024 && endPort > beginPort){
            setPortRange(beginPort, endPort);
        } else {
            // error
            $('#portResult').html('<div class="alert alert-danger"> Invalid input; ports should be over 1024 </div>');
        }
    });

    function getPortRange(){
        var formData = {
            'getPortRange'  : true,
        };
        
        $.ajax({
            url     : 'php_functions/admin_functions.php',
            data    : formData,
            dataType: 'json',
            method  : 'post'
        }).done(function(data){
            $('#begin_port').val(data['begin_port']);
            $('#begin_port').prop('disabled', false);
            $('#begin_port').attr('placeholder', 'Begin port');

            $('#end_port').val(data['end_port']);
            $('#end_port').prop('disabled', false);
            $('#end_port').attr('placeholder', 'End port');

        }).fail(function(data){
            console.log('Failed to get port range!');
            console.log(data);
            $('#begin_port').prop('disabled', false);
            $('#end_port').prop('disabled', false);
            $('#begin_port').attr('placeholder', 'Begin port');
            $('#end_port').attr('placeholder', 'End port');
        });
    }

    function setPortRange(beginPort, endPort){
        var formData = {
            'setPortRange'  : true,
            'beginPort'     : beginPort,
            'endPort'       : endPort
        };
        
        $.ajax({
            url     : 'php_functions/admin_functions.php',
            data    : formData,
            dataType: 'json',
            method  : 'post'
        }).done(function(data){
            $('#portResult').html('<div class="alert alert-success">Port range successfully set!</div>');
        }).fail(function(data){
            console.log(data);
            $('#portResult').html('<div class="alert alert-danger">There was an error processing the ports :s</div>');
        });

    }
});
