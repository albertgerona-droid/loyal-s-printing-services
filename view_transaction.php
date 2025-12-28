<?php
    include 'index.php';
    if(isset($_GET['action_id']) && isset($_GET['location_back'])){
        $action_id = $_GET['action_id'] ?? '';
        $location_back = $_GET['location_back'] ?? '';
    }
?>

<div class="modal fade" id="modal_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Daily Transaction</h1>
        <button type="button" onclick="location.href='<?php echo $location_back; ?>'" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="overflow-auto">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date Uploaded</th>
                        <th>Time Uploded</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $get_mytransaction= $conn->prepare("SELECT * FROM `transaction` WHERE `action_id` = ?");
                        $get_mytransaction->bind_param("s",$action_id);
                        $get_mytransaction->execute();
                        $result_transaction = $get_mytransaction->get_result();
                        if($result_transaction->num_rows>0){
                          while($row_trasaction = mysqli_fetch_assoc($result_transaction)){
                            $type = htmlspecialchars($row_trasaction['type'] ?? '');
                            $quantity = htmlspecialchars($row_trasaction['quantity'] ?? '');
                            $total = htmlspecialchars($row_trasaction['total'] ?? '');
                            $date_uploaded = htmlspecialchars($row_trasaction['date_uploaded'] ?? '');
                            $time_uploaded = htmlspecialchars($row_trasaction['time_uploaded'] ?? '');
                            ?>
                             <tr>
                              <td><?php echo $type; ?></td>
                              <td><?php echo $quantity; ?></td>
                              <td>&#8369; <?php echo $total; ?></td>
                              <td><?php echo $date_uploaded; ?></td>
                              <td><?php echo $time_uploaded; ?></td>
                            </tr>
                            <?php

                          }
                        }else{
                          echo "<tr><td colspan='5'>No Trasaction Found</td></tr>";
                        }
                      ?>
                     
                    </tbody>
                  </table>
              </div>
      </div>
      <div class="modal-footer  border-0">

      </div>
    </div>
  </div>
</div>

<script>
    
/* modal show*/
document.addEventListener("DOMContentLoaded", ()=> {
    let myModal = new bootstrap.Modal(document.getElementById('modal_data'));
    myModal.show();
});

</script>