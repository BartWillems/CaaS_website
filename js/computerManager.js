$( document ).ready(function() {

    getComputers();

    $('#addComputerBtn').click(function(){
        var computerName = $('#container_name').val();
        var password = $('#password').val();
        var passwordRepeat = $('#password_repeat').val();
        if(computerName){
            if(password === $('#password_repeat').val()){
                addComputerToDB(computerName);
                $('#addComputerResult').html('');
            } else {
                $('#addComputerResult').html('<div class="alert alert-danger">Your passwords don\'t match!</div>');
            }
        } else {
            $('#addComputerResult').html('<div class="alert alert-danger">You need to name your computer!</div>');
        }
    });

    function displayComputers(computers){
        var computerLen = computers.length;
        var height = $('#container_preview_base').width() / 1.75;
        var html  = '<div class="row" id="firstRow"><div class="col-md-4 portfolio-item"><a href="#" data-toggle="modal" data-target="#add-computer-modal">';
            html += '<div class="container_preview" id="container_preview_base"><div class="container_preview_overlay">';
            html += '<span class="glyphicon glyphicon-plus add_container_btn" aria-hidden="true"></span></div></div>';
            html += '</a><h3><a href="#" data-toggle="modal" data-target="#add-computer-modal">Add a Computer</a></h3></div>';
        for(var i = 0; i<computerLen; i++){
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
        }
        html += '</div>';
        $('#firstRow').html(html);
        var $window = $(window).bind('resize', function(){
            var height = $('#container_preview_base').width() / 1.75;
            $('.container_preview').height(height);
        }).trigger('resize');

    }

    function addComputerToDB(computerName){
        var formData = {
            'addComputerToDB'  : true,
            'container_name'     : computerName,
        };

        $.ajax({
            url     : 'php_functions/add_computer.php',
            data    : formData,
            dataType: 'json',
            method  : 'post'
        }).done(function(data){
            console.log(data);
            $('#addComputerResult').html('<div class="alert alert-success">Computer added successfully!</div>');
            getComputers();
        }).fail(function(data){
            console.log(data);
            if(data.responseJSON){
                $('#addComputerResult').html('<div class="alert alert-danger">' + data.responseJSON  + '</div>');
            } else {
                $('#addComputerResult').html('<div class="alert alert-danger">There was an error adding the computer </div>');
            }
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
            displayComputers(data);
        }).fail(function(data) {
            console.log(data);
        });
    }
});
