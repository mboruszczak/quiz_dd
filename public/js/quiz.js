$(document).ready(function(){
    
    $("input[name='answer']").click(function() {

        if($("input[name='answer']").is(':checked')) {

            $("#submit-btn").attr('disabled', false);
            
        }
        else {
            
            $("#submit-btn").attr('disabled', true);
            
        }
    });
    
});
