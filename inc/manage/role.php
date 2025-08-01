<?php

echo"<div class='col-12' style='border:1px solid #dbdbdb;padding:11px 11px;border-radius:11px;'>";
            echo"<div class='col-12 row' style='color:#06f;padding-bottom:6px;border-bottom:1px solid #dbdbdb;'>
                    <div class='col-1'>Id</div><div class='col'>Title</div><div class='col'>Total Users</div><div class='col'>Status</div><div class='col'>Actions</div>
                </div>";    
                $q = "SELECT * FROM zw_user_roles"; $qn = mysqli_query($con,"$q");
                while($cic=mysqli_fetch_assoc($qn)){
                    $aid = $cic['id']; $anm = $cic['title']; $ast = $cic['status']; if($ast==1){$astx="Active";}else{$astx="Inactive";}
                    echo"<div class='col-12 row' style='padding:11px 0px;'>";
                        echo"<div class='col-1'>$aid</div>";
                        echo"<div class='col'>$anm</div>";
                        echo"<div class='col'>".countRows("zw_user WHERE user_role='$aid'")." Users</div>";
                        echo"<div class='col'>$astx</div>";
                        echo"<div class='col'><a href='edit.php?type=role&id=$aid' style='margin-right:11px;'>Edit</a><a href='delete.php?type=role&id=$aid'>Delete</a></div>";
                    echo"</div>";
                    
                    
                }
                echo"</div>";
                
                
?>