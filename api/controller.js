
function login(model,met,email,pass) {
    
    let user_email = document.getElementById(email).value;
    let user_password = document.getElementById(pass).value;
    
    let output = "#"+model;
    
        $.ajax({
            type: met,
            url:"index.php",
            data: {
                   'Table' : model,
                   'action': 'login',
                   'email' : user_email,
                   'pass' : user_password
                  },
            success: function(answer){
                
               if(answer != '') { 
                   $(output).html("<pre>"+answer+"</pre>"+"<br><button type='button' class='btn btn-primary' onclick='logout()'>Выход</button>");
               }
               else alert('Error');
            }
        });
    
    }
    
    function logout() {
    let output = "#Users";
        $.ajax({
            type: 'GET',
            url:"index.php",
            data: {
                   'Table' : 'Users',
                   'action': 'logout'
                  },
            success: function(answer){
                
               if(answer != '') { 
                   $(output).html('Всего хорошего.');
               }
               else alert('Error');
            }
        });
    
    }