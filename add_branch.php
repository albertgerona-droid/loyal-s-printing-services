<?php
    include 'users.php';
    include '../alerts.php'; 

?>


<main>
    <section class="add_branch_section">
        <form action="function.php" method="POST">
            <div class="modal fade" id="modal_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5 fw-bold" id="staticBackdropLabel"><img src="../image/branch.png" alt=""> Add Branch</h1>
                    <button type="button" onclick="location.href='users.php'" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Branch Name</label>
                        <input type="text" class="form-control inputs" value="<?php echo $_SESSION['branch_name'] ?? ''; ?>" name="branch_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control inputs"  value="<?php echo $_SESSION['email'] ?? ''; ?>" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Location</label>
                        <input type="text" class="form-control inputs"  value="<?php echo $_SESSION['location'] ?? ''; ?>" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control inputs" id="password"  value="<?php echo $_SESSION['password'] ?? ''; ?>" name="password" required>
                        <span class="d-flex justify-content-end gap-1">
                            <input type="checkbox" id="checkbox" >
                            <p class="m-0" id="text">View</p>
                        </span>
                    </div>
                </div>
                <div class="modal-footer border-0">
                      <button type="submit" name="add_branch" class="btn btn-primary">Add Branch</button>

                </div>
                </div>
            </div>
        </div>
        </form>
    </section>
</main>

