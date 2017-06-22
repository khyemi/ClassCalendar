/** JavaScript Controller **/
function cancel_edit(id)
{
  location.reload();
}

function edit_row(id)
{
   var name = document.getElementById("name_val"+id).innerHTML;
   var login = document.getElementById("login_val"+id).innerHTML;
   var password = document.getElementById("password_val"+id).innerHTML;

   document.getElementById("name_val"+id).innerHTML="<input type='text' id='name_text"+id+"' value='"+name+"'>";
   document.getElementById("login_val"+id).innerHTML="<input type='text' id='login_text"+id+"' value='"+login+"'>";
   document.getElementById("password_val"+id).innerHTML="<input type='text' id='password_text"+id+"' value='"+password+"'>";
  	
   document.getElementById("edit_button"+id).style.display="none";
   document.getElementById("delete_button"+id).style.display="none";
   document.getElementById("save_button"+id).style.display="block";
   document.getElementById("cancel_button"+id).style.display="block";
}

function save_row(id)
{
   var name=document.getElementById("name_text"+id).value;
   var login=document.getElementById("login_text"+id).value;
   var password=document.getElementById("password_text"+id).value;
  	
   $.ajax
   ({
    type:'post',
    url:'../users.php',
    data:{
     edit_row:'edit_row',
     row_id:id,
     name_val:name,
     login_val:login,
     password_val:password,
    },
    success:function(response) {
       if(response=="success")
       {
        document.getElementById("name_val"+id).innerHTML=name;
        document.getElementById("login_val"+id).innerHTML=login;
        document.getElementById("password_val"+id).innerHTML=password;
        document.getElementById("edit_button"+id).style.display="block";
        document.getElementById("delete_button"+id).style.display="block";
        document.getElementById("save_button"+id).style.display="none";
        document.getElementById("cancel_button"+id).style.display="none";
        document.getElementById("msg").innerHTML="User successfully updated";
       }
       else{
        document.getElementById("msg").innerHTML="There is a problem updating the user";
       }
    }
   });
}

function delete_row(id)
{
   $.ajax
   ({
    type:'post',
    url:'../users.php',
    data:{
     delete_row:'delete_row',
     row_id:id,
    },
    success:function(response) {
     if(response=="success")
     {
      var row=document.getElementById("row"+id);
      row.parentNode.removeChild(row);
      document.getElementById("msg").innerHTML="User successfully deleted";
     }
    }
   });
}

function insert_row()
{
   var name=document.getElementById("new_name").value;
   var login=document.getElementById("new_login").value;
   var password=document.getElementById("new_password").value;

   $.ajax
   ({
    type:'post',
    url:'../users.php',
    data:{
     insert_row:'insert_row',
     name_val:name,
     login_val:login,
     password_val:password,
    },
    success:function(response) {
       if(response=="success")
       {
          document.getElementById("msg").innerHTML="User successfully added";          
          window.setTimeout(function(){location.reload()},1000); //Reload page after display message
       }
       else if(response=="blank"){
          document.getElementById("msg").innerHTML="Please enter all fields";
       }
       else{
          document.getElementById("msg").innerHTML="User with the same login already exists";
       }    
    }

   });
}