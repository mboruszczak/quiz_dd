$(document).ready(function(){
    questType();
    $("input[name='answer[]']").click(function() {

        if($("input[name='answer[]']").is(':checked')) {

            $("#submit-btn").attr('disabled', false);
            
        }
        else {
            
            $("#submit-btn").attr('disabled', true);
            
        }
    });
    
    
    function questType() 
    {
        var single = $('input[data-type="single"]');
        var multi = $('input[data-type="multi"]');

        if(single.is(':checked')) {
            $('input[name="correct[]"]').prop('type', 'radio');
        }
        else if(multi.is(':checked')) {
            $('input[name="correct[]"]').prop('type', 'checkbox');
        }
    }
    
    $('input[name="quest_type"]').click(function(){
        questType();
    });
    
});
