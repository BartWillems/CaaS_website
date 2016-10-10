$( document ).ready(function() {
    var register = Boolean(true);
    $("#register").click(function() {
        if(register){
            $("#form_fields").append('<input id="password_match" type="password" name="password_match" placeholder="Verify password">');
            $(".loginmodal-container").find("h1").text("Create an account");
            $("#loginBtn").attr("value","Register");
            $("#register").text("Cancel");
            $("#login_form").attr("action","register.php");
            register = false;
        } else {
            $("#password_match").remove();
            $(".loginmodal-container").find("h1").text("Login to Your Account");
            $("#password_match").remove();
            $("#loginBtn").attr("value","Login");
            $("#register").text("Don't have an account? Register now!");
            $("#login_form").attr("action","login.php");
            register = true;
        }
    });
});
