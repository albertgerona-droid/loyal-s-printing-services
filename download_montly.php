<?php
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monthly Sales Report</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
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
    }
  </style>

  <!-- ✅ html2canvas + jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-light">

  <div id="loadingScreen">
    <div class="spinner-border text-primary" role="status"></div>
    <div class="downloading-text">Generating Monthly Sales Report...</div>
  </div>

  <div class="container mt-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div id="monthlyTable" class="table-responsive">

          <h3 class="text-center mb-3">Monthly Sales Report</h3>
          <?php
            // 🗓 Get selected month or current month
            $selected_month = $_GET['month'] ?? date('Y-m');
            $month_start = $selected_month . '-01';
            $month_end = date('Y-m-t', strtotime($month_start)); // end of month
          ?>

          <p class="text-center mb-4"><strong>Period:</strong> <?php echo date('F Y', strtotime($selected_month)); ?></p>

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
              $get_invoice = $conn->prepare("
                SELECT * FROM `invoice` 
                WHERE `date_transaction` BETWEEN ? AND ?
                ORDER BY `date_transaction` ASC
              ");
              $get_invoice->bind_param("ss", $month_start, $month_end);
              $get_invoice->execute();
              $result = $get_invoice->get_result();

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $user_id = htmlspecialchars($row['user_id']);
                  $get_branch = $conn->prepare("SELECT branch_name FROM `accounts` WHERE `user_id` = ?");
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
                echo "<tr><td colspan='7' class='text-center text-muted'>No transactions found for this month.</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <!-- 🧾 TOTAL SALES REPORT -->
          <h3 class="text-center mb-3">Total Sales per Branch</h3>
          <div class="overflow-auto">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>Total Sales</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // ✅ Summarize total per branch for the month
                $query = $conn->prepare("
                  SELECT a.branch_name, SUM(t.amount) AS total_sales
                  FROM invoice t
                  JOIN accounts a ON t.user_id = a.user_id
                  WHERE t.date_transaction BETWEEN ? AND ?
                  GROUP BY a.branch_name
                  ORDER BY a.branch_name ASC
                ");
                $query->bind_param("ss", $month_start, $month_end);
                $query->execute();
                $result_q = $query->get_result();

                $grand_total = 0;

                if ($result_q->num_rows > 0) {
                  while ($row = $result_q->fetch_assoc()) {
                    $branch_name = htmlspecialchars($row['branch_name']);
                    $total_sales = $row['total_sales'];
                    $grand_total += $total_sales;

                    echo "<tr>
                            <td>{$branch_name}</td>
                            <td>₱" . number_format($total_sales, 2) . "</td>
                          </tr>";
                  }

                  echo "<tr class='fw-bold'>
                          <td class='text-end'>Grand Total:</td>
                          <td>₱" . number_format($grand_total, 2) . "</td>
                        </tr>";
                } else {
                  echo "<tr><td colspan='2' class='text-center text-muted'>No data available for this month.</td></tr>";
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

      await new Promise(resolve => setTimeout(resolve, 400));

      const canvas = await html2canvas(element, { scale: 2 });
      const imgData = canvas.toDataURL('image/png');
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

      await new Promise(resolve => {
        pdf.save(filename + '.pdf', { returnPromise: true }).then(resolve);
      });
    }

    window.onload = async () => {
      const loadingText = document.querySelector('.downloading-text');
      loadingText.textContent = 'Preparing your monthly report...';

      await downloadPDF('monthlyTable', 'Monthly_Sales_<?php echo date('Y-m', strtotime($selected_month)); ?>');

      loadingText.textContent = 'Download complete! Redirecting...';
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
