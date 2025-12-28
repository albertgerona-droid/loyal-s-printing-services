<?php
    include '../config.php';

?>


<div class="overflow">
    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Pages</th>
                <th>Copies</th>
                <th>Total</th>
                <th>Branch</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_transaction =  $conn->prepare("SELECT * FROM `transaction` GROUP BY action_id ORDER BY  date_uploaded DESC");
            $get_transaction->execute();
            $result_transaction = $get_transaction->get_result();
            if($result_transaction->num_rows>0){
                while($row_trasaction = mysqli_fetch_assoc($result_transaction)){
                    $type = htmlspecialchars($row_trasaction['type']);
                    $quantity = htmlspecialchars($row_trasaction['quantity']);
                    $total = htmlspecialchars($row_trasaction['total']);
                    $user_id = htmlspecialchars($row_trasaction['user_id']);
                    $file = htmlspecialchars($row_trasaction['file']);
                    $date_uploaded = htmlspecialchars($row_trasaction['date_uploaded']);
                    $time_uploaded = htmlspecialchars($row_trasaction['time_uploaded']);
                     $copies = htmlspecialchars($row_trasaction['copies']);



            $get = $conn->prepare("SELECT * FROM `accounts` WHERE `user_id` = ?");
            $get->bind_param("s",$user_id);
            $get->execute();
            $result_account = $get->get_result();
            if($result_account->num_rows>0){
                while($row_account = mysqli_fetch_assoc($result_account)){
                    $branch = htmlspecialchars($row_account['branch_name']);
             
                    ?>
                    <tr>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $copies; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $branch; ?></td>
                        <td><?php echo $date_uploaded; ?></td>
                        <td><?php echo $time_uploaded; ?></td>
                    </tr>
                    <?php
                       }
            }
                 
                }
            }else{
                echo "<tr><td colspan='6'>No Transaction Found</td></tr>";
            }
            ?>
           
        </tbody>
    </table>
</div>
