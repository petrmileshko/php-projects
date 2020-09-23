function addOneToBasket(product_id,user_id,product_price) {
    
       let idProduct = "Product_"+product_id;
       let idTotalProduct = "TotalProduct_"+product_id;
    
       let quantity = document.getElementById(idProduct).value;
       let totalProduct = document.getElementById(idTotalProduct).value;
       let totalBasket  = document.getElementById("TotalBasket").value;
    
       let str = "product="+product_id+"&user="+user_id+"&action=1";
       
        $.ajax({
            type:"GET",
            url:"engine/ajax.php",
            data:str,
            success: function(answer){
                
               if(answer = '1') { 
                   document.getElementById(idProduct).value = parseInt(quantity) + 1;
                   document.getElementById(idTotalProduct).value = parseInt(totalProduct) + parseInt(product_price);
                   document.getElementById("TotalBasket").value = parseInt(totalBasket) + parseInt(product_price);
               }
               else alert(answer);
            }
        });
    }

function deductOneFromBasket(product_id,user_id,product_price) {
    
       let idProduct = "Product_"+product_id
       let idTotalProduct = "TotalProduct_"+product_id;
  
       let quantity = document.getElementById(idProduct).value;
       let totalProduct = document.getElementById(idTotalProduct).value;
       let totalBasket  = document.getElementById("TotalBasket").value;
    
       let str = "product="+product_id+"&user="+user_id+"&action=2";
       
       if(parseInt(quantity) > 0) {
           $.ajax({
            type:"GET",
            url:"engine/ajax.php",
            data:str,
            success: function(answer){
                
               if(answer = '1') { 
                   
                  
                   document.getElementById(idProduct).value = parseInt(quantity) - 1;
                   document.getElementById(idTotalProduct).value = parseInt(totalProduct) - parseInt(product_price);
                   document.getElementById("TotalBasket").value = parseInt(totalBasket) - parseInt(product_price);
                   
                   
               }
               else alert(answer);
            }
        });
       }
    }

function deleteAllFromBasket(product_id,user_id) {
    
       let idTotalProduct = "TotalProduct_"+product_id;

       let deletetotalProduct = document.getElementById(idTotalProduct).value;
       let deletetotalBasket  = document.getElementById("TotalBasket").value;
    
       let str = "product="+product_id+"&user="+user_id+"&action=3";
     
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

function deleteProduct(product_id) {
    
       let str = "product="+product_id+"&action=4";
    
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

function deleteImage(img_id) {
    
       let str = "image="+img_id+"&action=5";
    
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

function deleteUser(user_id) {
    
       let str = "user="+user_id+"&action=6";
    
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

function deleteOrder(order_id) {
    
       let str = "order="+order_id+"&action=7";
    
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

$(document).ready(function(){
    if ($('#promo').length > 0) {
        $('#content').removeAttr('id');
    }
});