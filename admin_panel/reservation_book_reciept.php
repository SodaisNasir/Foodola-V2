<?php
include_once('connection.php');
date_default_timezone_set('Asia/Karachi');

$reservation_id = intval($_GET['reservation_id'] ?? 0);
if (!$reservation_id) {
    die("Invalid Reservation ID");
}

// Fetch reservation with table name
$sql = "
    SELECT r.*, t.table_name, u.name AS user_name, u.phone AS user_phone
    FROM reservations r
    LEFT JOIN tables t ON t.id = r.table_id
    LEFT JOIN users u ON u.id = r.user_id
    WHERE r.id = $reservation_id
";
$res = mysqli_query($conn, $sql);
$reservation = mysqli_fetch_assoc($res);

if (!$reservation) {
    die("Reservation not found");
}

$APP_NAME = $APP_NAME ?? 'Restaurant';
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Reservation confirmation</title>

<style>
/* --- PRINT STYLES --- */
@media print {
  .button { display:none; }
  @page { margin:1mm; } /* minimal margin for printer */

  html, body {
    background:none;
    margin:0 !important;
    padding:0 !important;
    width:100% !important;
    font-family:'Poppins', sans-serif !important;
    font-size:18px;
  }

  .receipt-container {
    width:100% !important;
    max-width:80mm; /* adjust for thermal printer width */
    margin:0;
    padding:0;
    text-align:left;
    box-shadow:none;
    border:none;
  }

  .header, .details, .order-details-header, table, .footer {
    margin:0;
    padding:0;
  }

  .big-order {
    font-size:22px;
    font-weight:900;
    padding:4px 0;
    margin:4px 0;
    letter-spacing:1px;
    border-top:4px solid #000;
    border-bottom:4px solid #000;
    text-align:center;
  }

  .details p {
    margin:0;
    padding:2px 0;
    font-size:13px;
    text-align: center;
  }

  .order-details-header {
    text-align:center;
    font-weight:bold;
    font-size:14px;
    margin:6px 0;
    padding:0;
  }

  table {
    width:100% !important;
    border-collapse:collapse;
    margin:0;
  }

  td {
    padding:2px 25px;
    font-size:13px;
    vertical-align:top;
    
  }
  

  .label {
    font-weight:bold;
  }

  .footer {
    margin-top:8px;
    border-top:1px dashed #000;
    padding-top:5px;
    text-align:center;
    font-size:13px;
    font-weight:bold;
  }
}

/* --- SCREEN STYLES --- */
body {
  font-family:Arial;
  font-size:14px;
  background:#fff;
  margin:0;
}

.receipt-container { max-width:80mm; margin:0 auto; }
.header { text-align:center; }
</style>
</head>

<body>
<div class="receipt-container">

  <div class="header">
    <h2><?php echo $APP_NAME; ?></h2>

    <div class="big-order">
      RESERVATION #<?php echo $reservation['id']; ?>
    </div>
  </div>

  <div class="details">
    <p><strong>Table:</strong> <?php echo $reservation['table_name'] ?? 'Kein Tisch'; ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst($reservation['status']); ?></p>
    <p><strong>Created:</strong>
      <?php echo date('d.m.Y H:i', strtotime($reservation['created_at'])); ?>
    </p>
  </div>

  <div class="order-details-header">RESERVATION DETAILS</div>

  <table >
    <tbody>
        <?php if (!empty($reservation['user_name'])): ?>
      <tr>
        <td class="label">Name</td>
        <td><strong><?php echo htmlspecialchars($reservation['user_name']); ?></strong></td>
      </tr>
      <?php endif; ?>

      <?php if (!empty($reservation['user_phone'])): ?>
      <tr>
        <td class="label">Phone</td>
        <td><strong><?php echo htmlspecialchars($reservation['user_phone']); ?></strong></td>
      </tr>
      <?php endif; ?>

      <tr>
        <td class="label">Date</td>
        <td><?php echo date('d.m.Y', strtotime($reservation['reservation_date'])); ?></td>
      </tr>
      <tr>
        <td class="label">Time</td>
        <td>
          <?php echo date('H:i', strtotime($reservation['start_time'])); ?>
          –
          <?php echo date('H:i', strtotime($reservation['end_time'])); ?>
        </td>
      </tr>
      <tr>
        <td class="label">Length of time</td>
        <td><?php echo $reservation['duration_minutes']; ?> Minutes</td>
      </tr>
      <tr>
        <td class="label">Persons</td>
        <td><?php echo $reservation['people']; ?></td>
      </tr>
      <tr>
        <td class="label">Fee</td>
        <td>€<?php echo number_format($reservation['reservation_fees'], 2); ?></td>
      </tr>
    </tbody>
  </table>

  <div class="footer">
    <p>Thank you for your reservation!</p>
  </div>

</div>

<script>
window.onload = () => window.print();
</script>
</body>
</html>
