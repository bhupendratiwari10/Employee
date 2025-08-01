<?php

if(isset($_POST['title'])){
        
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        $query = "INSERT INTO `zw_pickup_categories` (`id`, `title`, `description`, `time_str`) VALUES (NULL, '$title', '$desc', current_timestamp());";
        if(mysqli_query($con,$query)){alert("Category Added");}else{alert("Category Entry Failed");}
        
    }


?>

    <h2>New Category</h2><br>
    <form action="" method="post" class='m-0 p-0'>
            
        
            <label for="title">Category Title</label>
            <input class='col-md-6 form-control' type="text" name="title" placeholder="Category Title" required>

            <label for="desc" style='margin-top:8px;'>Category Details:</label>
            <textarea class='form-control col-md-6' placeholder="Category Details" name="desc"></textarea>
        
        <br><button class='btn btn-info' type="submit">Submit</button>
    </form>