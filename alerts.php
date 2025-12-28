
<?php 
    $success_icon = "image/approved.gif";
    $fallback_icon = "../image/approved.gif";

    if (file_exists($success_icon)) {
        $icon_path_success = $success_icon;
    } elseif (file_exists($fallback_icon)) {
        $icon_path_success = $fallback_icon;
    } else {
        $icon_path_success = ""; 
    }
?>

<?php if (isset($_SESSION['success'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        title: "SUCCESS",
        html: `
          <p><?= $_SESSION['success']; ?></p>
          <img src="<?= $icon_path_success; ?>"  style='width:100'  />
        `,
        showConfirmButton: true,
        didOpen: () => {
          document.querySelector('.swal2-container').style.zIndex = "20000";
        }
      });
    });
  </script>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>



<?php 
    $error_icon = "image/no-data.gif";
    $fallback_icon_error = "../image/no-data.gif";

    if (file_exists($error_icon)) {
        $icon_path_error = $error_icon;
    } elseif (file_exists($fallback_icon_error)) {
        $icon_path_error = $fallback_icon_error;
    } else {
        $icon_path_error = ""; 
    }
?>

<!--sweet alert error -->
<?php if (isset($_SESSION['error'])): ?>
   <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        title: "ERROR",
        html: `
          <p><?= $_SESSION['error']; ?></p>
          <img src="<?= $icon_path_error; ?>" style='width:100'  />
        `,
        showConfirmButton: true,
        didOpen: () => {
          document.querySelector('.swal2-container').style.zIndex = "20000";
        }
      });
    });
  </script>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

