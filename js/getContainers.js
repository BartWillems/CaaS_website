$(document).ready(function(){
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
        for(var container in data){
            console.log(data[count].container_name);
            console.log(data[count].container_id);
            console.log(data[count].fq_container_name);
            count++;
        }
    }).fail(function(data) {
        console.log(data);
    });
});
