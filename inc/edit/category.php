<?php

$prevTitle = namebyAid($uid, "title", "zw_pickup_categories");
$prevDesc = namebyAid($uid, "description", "zw_pickup_categories");

if(isset($_POST['title'])){
        
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        
        if($title!=$prevTitle){$qu1="`title`='$title'";}else{$qul1='1';}
        if($desc!=$prevDesc){$qu2="`description`='$desc'";}else{$qul2='1';}
        
        if($qul1!='1' AND $qul2!='1'){$quu=$qu1." , ".$qu2;}else{$quu=$qu1.$qu2;}
        
        $query = "UPDATE `zw_pickup_categories` SET $quu WHERE id='$uid'";
        if(mysqli_query($con,$query)){alert("Category Updated successfully.");echo"<script>location.href='?type=categories&id=$uid';</script>";}else{alert("Edit Failed");}
        
    }


?>


    <h2>Edit Category</h2><br>
    <form action="" method="post" class='m-0 p-0'>
            
        
            <label for="title">Category Title</label>
            <input class='col-md-6 form-control' type="text" name="title" placeholder="Category Title" value="<?php echo $prevTitle; ?>" required>

            <label for="desc" style='margin-top:8px;'>Category Details:</label>
            <textarea class='form-control col-md-6' placeholder="Category Details" name="desc"><?php echo $prevDesc; ?></textarea>
        
        <br><button class='btn btn-info' type="submit">Submit</button>
    </form>