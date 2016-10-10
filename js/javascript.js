$( document ).ready(function() {
    var register = Boolean(false);
    $("#register").click(function() {
        $("#form_fields").append('<input id="password_match" type="password" name="password_match" placeholder="Verify password">');
        register = true;
    });
    
    $("#cancel").click(function() {
        $("#password_match").remove();
        register = false;
    });
});
