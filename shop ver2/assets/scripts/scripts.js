
function controller(model,action,id) {
    
    let uri = "m="+model+"&act="+action+"&id="+id;
    let output = "#"+model;
    
        $.ajax({
            type:"POST",
            url:"ajax.php",
            data: uri,
            success: function(answer){
                
               if(answer != '') { 
                   $(output).html(answer);
               }
               else alert('Error');
            }
        });
    
    }

