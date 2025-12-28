<?php include 'stocks.php'; ?>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog " >
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel">Low Stocks</h1>
        <button type="button" onclick="lcoation.href='stocks.php'" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Stocks</th>
                    </tr>
                </thead>
                <tbody>
                   <tbody>
                <?php
                $get = $conn->prepare("SELECT * FROM `stocks` WHERE `user_id` = ?");
                $get->bind_param("s", $user_idko);
                $get->execute();
                $result_get = $get->get_result();

                if ($result_get->num_rows > 0) {
                    while ($row = $result_get->fetch_assoc()) {

                        $stocks = [
                            'Laminating Plastic' => (int) ($row['laminating_plastic'] ?? 0),
                            'Long Bond Paper'    => (int) ($row['long_bond_paper'] ?? 0),
                            'Photo Paper'        => (int) ($row['photo_paper'] ?? 0),
                            'Short Bond Paper'   => (int) ($row['short_bond_paper'] ?? 0),
                            'A4 Bond Paper'      => (int) ($row['a4_bond_paper'] ?? 0),
                        ];

                        foreach ($stocks as $type => $qty) {
                            if ($qty <= 50) {
                                echo "
                                <tr>
                                    <td>{$type}</td>
                                    <td class='text-danger fw-bold'>{$qty}</td>
                                </tr>";
                            }
                        }
                    }
                }
                ?>
                </tbody>

                 
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer border-0">
        
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $('#staticBackdrop').modal('show');
});

</script>
