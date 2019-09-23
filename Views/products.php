<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
</head>
<body>
   <h1>Products</h1> 
   <div id="responsecontainer"></div>
   <script>
    $(document).ready(function() {

        $("#submit").click(function() {                

        $.ajax({    //create an ajax request to display.php
            type: "POST",
            url: "http://localhost/mvc/Products/fetchData",             
            data: "",   //expect html to be returned                
            success: function(response){                    
                
                var data = JSON.parse(response);
                $("#responsecontainer").html(data.path); 
                console.log(response);
            }

        });
        });
        });

    </script>
   <button type="submit" id="submit">Show Products</button>
   <input type="text" id="productValue">
   <script>
    $(document).ready(function() {

        $("#addProd").click(function() {   
            
            // var data = $("#productValue").val();             
            
        $.ajax({    //create an ajax request to display.php
            type: "POST",
            url: "http://localhost/mvc/Products/deleteData",             
            data: data,   //expect html to be returned                
            success: function(response){                    
                
                var data = JSON.parse(response);
                $("#responsecontainer").html(data); 
                console.log(response);
            }

        });
        });
        });

    </script>
   <button type="submit" id="addProd">Delete Product</button>
   <script>
    $(document).ready(function() {

        $("#updateProd").click(function() {                

        $.ajax({    //create an ajax request to display.php
            type: "POST",
            url: "http://localhost/mvc/Products/updateData",             
            data: "",   //expect html to be returned                
            success: function(response){                    
                
                var data = JSON.parse(response);
                $("#responsecontainer").html(data); 
                console.log(response);
            }

        });
        });
        });

    </script>
   <button type="submit" id="updateProd">Update Products</button>
</body>
</html>