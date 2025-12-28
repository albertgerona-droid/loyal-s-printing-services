<?php
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daily Sales Report</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
/*
    #loadingScreen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #f8f9fa;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .spinner-border {
      width: 3rem;
      height: 3rem;
    }

    .downloading-text {
      margin-top: 15px;
      font-weight: 600;
      color: #333;
      animation: blink 1.5s infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }*/
  </style>

  <!-- ✅ html2canvas + jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-light">


  <div id="loadingScreen">
    <div class="spinner-border text-primary" role="status"></div>
    <div class="downloading-text">Generating Daily Sales Report...</div>
  </div>

  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div id="dailyTable" class="table-responsive">

     
          <h3 class="text-center mb-3">Daily Sales Report</h3>
          <table class="table mb-5">
            <thead>
              <tr>
                <th>Branch Name</th>
                <th>Invoice ID</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Time</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $selected_date = $_GET['date'] ?? date('Y-m-d');
              $get_invoice = $conn->prepare("SELECT * FROM `invoice` WHERE `date_transaction` = ? ");
              $get_invoice->bind_param("s", $selected_date);
              $get_invoice->execute();
              $result = $get_invoice->get_result();

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $user_id = htmlspecialchars($row['user_id']);
                  $get_branch = $conn->prepare("SELECT branch_name FROM `accounts` WHERE `user_id` = ?  ORDER BY  branch_name");
                  $get_branch->bind_param("s", $user_id);
                  $get_branch->execute();
                  $result_b = $get_branch->get_result();

                  if ($result_b->num_rows > 0) {
                    $branch = $result_b->fetch_assoc();
                    echo "<tr>
                            <td>{$branch['branch_name']}</td>
                            <td>{$row['invoice_id']}</td>
                            <td>{$row['quantity']}</td>
                            <td>₱" . number_format($row['amount'], 2) . "</td>
                            <td>{$row['time_transaction']}</td>
                            <td>{$row['date_transaction']}</td>
                          </tr>";
                  }
                }
              } else {
                echo "<tr><td colspan='7' class='text-center text-muted'>No transactions found.</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <!-- 🧾 TOTAL SALES REPORT -->
          <h3 class="text-center mb-3">Total Sales Report</h3>
          <div class="overflow-auto">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                 <?php
      // ✅ Select one row per branch with total sales summed up
      $query = $conn->query("
        SELECT a.branch_name, SUM(t.amount) AS total_sales
        FROM invoice t
        JOIN accounts a ON t.user_id = a.user_id
        WHERE DATE(t.date_transaction) = CURDATE()
        ORDER BY a.branch_name ASC
      ");

      $grand_total = 0;

      if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
          $branch_name = htmlspecialchars($row['branch_name']);
          $total_sales = $row['total_sales'];
          $grand_total += $total_sales;

          echo "<tr>
                  <td>{$branch_name}</td>
                  <td>₱" . number_format($total_sales, 2) . "</td>
                </tr>";
        }

        // ✅ Grand Total
        echo "<tr class='fw-bold'>
                <td class='text-end'>Grand Total:</td>
                <td>₱" . number_format($grand_total, 2) . "</td>
              </tr>";
      } else {
        echo "<tr><td colspan='2' class='text-center text-muted'>No transactions found.</td></tr>";
      }
      ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ✅ JS -->
  <script>
    async function downloadPDF(tableId, filename) {
      const { jsPDF } = window.jspdf;
      const element = document.getElementById(tableId);
      const pdf = new jsPDF('p', 'pt', 'a4');

      // Small delay for rendering
      await new Promise(resolve => setTimeout(resolve, 400));

      const canvas = await html2canvas(element, { scale: 2 });
      const imgData = canvas.toDataURL('image/png');
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

      // Wait for the download before redirect
      await new Promise(resolve => {
        pdf.save(filename + '.pdf', { returnPromise: true }).then(resolve);
      });
    }

    window.onload = async () => {
      const loadingText = document.querySelector('.downloading-text');
      loadingText.textContent = 'Preparing your report...';

      await downloadPDF('dailyTable', 'Daily_Sales_<?php echo date('Y-m-d'); ?>');

      loadingText.textContent = 'Download complete! Redirecting...';

      // Optional: hide loading before redirect
      document.getElementById('loadingScreen').style.display = 'none';

      setTimeout(() => {
        window.location.href = 'sales.php';
      }, 1000);
    };
  </script>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
