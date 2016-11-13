$( document ).ready(function() {

    getComputers();


    $('#addComputerBtn').click(function(){
        var computerName = $('#container_name').val();
        if(computerName){
            addComputer(computerName);
            $('#addComputerResult').html('');
        } else {
            $('#addComputerResult').html('<div class="alert alert-danger">You need to name your computer!</div>');
        }
    });

    function addComputer(computerName){
        var formData = {
            'addComputer'  : true,
            'container_name'     : computerName,
        };

        $.ajax({
            url     : 'php_functions/add_computer.php',
            data    : formData,
            dataType: 'json',
            method  : 'post'
        }).done(function(data){
            $('#addComputerResult').html('<div class="alert alert-success">Computer added successfully!</div>');
        }).fail(function(data){
            console.log(data);
            $('#addComputerResult').html('<div class="alert alert-danger">There was an error adding the computer </div>');
        });

    }

    function getComputers(){
        var formData = {
            'request'  : 'request_all_for_user'
        };

        $.ajax({
            type    : 'POST',
            url     : '../php_functions/container_manager.php',
            data    : formData,
            dataType: 'json',
            encode  : 'true'
        }).done(function(data) {
            var count = 0;
            console.log('Success');
            console.log(data);
            // for(var container in data){
            //     console.log(data[count].container_name);
            //     console.log(data[count].container_id);
            //     console.log(data[count].fq_container_name);
            //     count++;
            // }
        }).fail(function(data) {
            console.log(data);
        });
    }
});
