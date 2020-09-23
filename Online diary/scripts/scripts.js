function deleteUser(user_id) {
    
       let str = "user="+user_id+"&action=1";
    
        $.ajax({
            type:"GET",
            url:"engine/ajax.php",
            data:str,
            success: function(answer){
                
               if(answer = '1') { 

               }
               else alert(answer);
            }
        });
                     location.reload();
    }