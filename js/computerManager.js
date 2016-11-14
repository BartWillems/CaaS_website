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

    function displayComputers(computers){
        var computerLen = computers.length;
        var firstRow = true;
        var height = $('#container_preview_base').width() / 1.75;
        for(var i = 0; i<computerLen; i++){
            var html = '';
            html += '<div class="col-md-4 portfolio-item">';
            html += '   <a href="computers/' + computers[i]['container_id']  + '">';
            html += '       <div class="container_preview" id="' + computers[i]['container_id'] + '" style="height: ' + height + 'px;">';
            html += '           <div class="container_preview_overlay">';
            html += '               <span class="glyphicon glyphicon-play-circle add_container_btn" aria-hidden="true"></span>';
            html += '           </div>';
            html += '       </div>';
            html += '   </a>';
            html += '   <h3>'; 
            html += '       <a href="computers/' + computers[i]['container_id']  + '">';
            html +=             computers[i]['container_name']; 
            html += '       </a>';
            html += '   </h3>';
            html += '</div>';
            if(i <= 1){
                $('#firstRow').append(html);
            }
        }
    }

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
            // console.log('Success');
            // console.log(data);
            displayComputers(data);
        }).fail(function(data) {
            console.log(data);
        });
    }
});
