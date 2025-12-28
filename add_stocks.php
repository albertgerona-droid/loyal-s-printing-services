<?php
 include 'stocks.php';
?>



<form action="function.php" method="POST">
    <div class="modal fade" id="modal_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
            <button type="button" class="btn-close" onclick="location.href='stocks.php'" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <div class="mb-3">
            <label for="" class="form-label">Laminating Plastic</label>
            <input type="number" name="laminating_plastic" class="form-control" >
           </div>
           <div class="mb-3">
            <label for="" class="form-label">Long Bond Paper </label>
            <input type="number" name="long_bond_paper" class="form-control" >
           </div>
           <div class="mb-3">
            <label for="" class="form-label">Short Bond Paper </label>
            <input type="number" name="short_bond_paper" class="form-control" >
           </div>
           <div class="mb-3">
            <label for="" class="form-label">a4 Bond Paper </label>
            <input type="number" name="a4_bond_paper" class="form-control" >
           </div>
            <div class="mb-3">
            <label for="" class="form-label">Photo Print Paper</label>
            <input type="number" name="photo_paper" class="form-control" >
           </div>
        </div>
        <div class="modal-footer">
            <input type="submit" name="save_stocks" class="btn btn-primary" value="Save Stocks">
        </div>
        </div>
    </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", ()=> {
        let myModal = new bootstrap.Modal(document.getElementById('modal_data'));
        myModal.show();
    });
</script>