//window.onload = function() {
$(document).ready(function() {
    $error = $('<center><label class = "text-danger">Please Fill up the form!</label></center>');
    $load_status = $('<center><label class = "text-success">Waiting...</label></center>');
    $group_valid = $('<center><label class = "text-danger">Member already joined!</label></center>');
    //alert("jquery is loaded");

//}
    
//});

$('#save_group').click(function(){
    $error.remove();
    $group_valid.remove();
    $ruser = $('#usermember').val();
    $pid = $('#project').val();
    alert("You had me at hello");
    if($ruser == "option" ){
        
        $error.appendTo('#loading');
    }else{
        $load_status.appendTo('#loading');
        setTimeout(function(){
            
            console.log("group_validator got loaded");
            $.post('group_validator.php', {r_user: $ruser, p_id : $pid},
                function(result){
                    if(result = "Success"){
                        alert("LOADED");
                        console.log("$.post call done");
                        console.log("result = " + result);
                        $group_valid.appendTo('#loading');
                        
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: 'save_group.php',
                            data: {r_user : $ruser, p_id : $pid},
                            success: function(){
                                window.location = 'group.php?pid=' + $pid;
                            }
                        });
                    }
                }
            )
        $load_status.remove();	
        }, 3000);
    }
});

});


