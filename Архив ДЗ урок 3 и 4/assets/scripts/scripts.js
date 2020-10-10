

function loadMore() {
    
    
        $.ajax({
            type:"POST",
            url:"index.php",
            data:'next=1',
            success: function(answer){
                
               if(answer != '') { 
                   $('#shopWrap').html(answer);
               }
               else alert('Error');
            }
        });
    }