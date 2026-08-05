<?php
include("connection.php");

$postData = [
    "token" => "as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC"
];

/* DATE (Daily Report) */
if (!empty($_REQUEST['date'])) {
    $postData['date'] = $_REQUEST['date'];
}

/* MONTH & YEAR (Monthly/Yearly Report) */
if (!empty($_REQUEST['month'])) {
    $postData['month'] = $_REQUEST['month'];
}

if (!empty($_REQUEST['year'])) {
    $postData['year'] = $_REQUEST['year'];
}

/* DATE RANGE */
if (!empty($_REQUEST['start_date']) && !empty($_REQUEST['end_date'])) {
    $postData['start_date'] = $_REQUEST['start_date'];
    $postData['end_date']   = $_REQUEST['end_date'];
}

$curl = curl_init();

curl_setopt_array($curl, [
     CURLOPT_URL => rtrim($BASE_URL, '/') . "/API/get_report_data.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    die(curl_error($curl));
}

curl_close($curl);

$report = json_decode($response, true);

$genDate = date('d.m.Y H:i');





$sql  = "SELECT * FROM `system_setting`";
$exec_sql = mysqli_query($conn, $sql);
$settings= mysqli_fetch_assoc($exec_sql);
$report_lang = $settings['report_lang'];

if ($report_lang == 'de') {

    $txt_operational_overview = "Betriebsübersicht";
    $txt_total_revenue = "Gesamtumsatz";
    $txt_total_orders = "Gesamtbestellungen";
    $txt_total_items = "Gesamtartikel";
    $txt_discount = "Rabatt";
    $txt_shipping = "Lieferkosten";

    $txt_sales_channels = "Vertriebskanäle";
    $txt_sum_orders = "Summe Bestellungen";

    $txt_payment_methods = "Zahlungsarten";

    $txt_cash = "BAR";
    $txt_online = "ONLINE";
    $txt_pickup_delivery_cash = "Abholung Bar / Lieferung Bar";
    $txt_pickup_delivery_online = "Abholung Online / Lieferung Online";

    $txt_tax_summary = "Steuerdetails & Übersicht";
    $txt_tax7_total = "7% Gesamt (inkl. Steuer)";
    $txt_tax19_total = "19% Gesamt (inkl. Steuer)";
    $txt_tax7 = "7% Steuer";
    $txt_tax19 = "19% Steuer";
    $txt_total_tax = "Gesamtsteuer";

    $txt_cash_vat = "BAR MwSt";
    $txt_online_vat = "ONLINE MwSt";

    $txt_total_cash_vat = "Gesamte Bar MwSt";
    $txt_total_online_vat = "Gesamte Online MwSt";

    $txt_performed_on = "Erstellt am";
    
        $txt_total_tax = "GESAMTSTEUER";
        
            $txt_online_vat = "ONLINE MwSt";
    $txt_cash_vat   = "BAR MwSt";
    
        $txt_total_cash_vat = "Gesamte Bar MwSt";
    $txt_total_online_vat = "Gesamte Online MwSt";
        $txt_total_revenue_label = "GESAMTUMSATZ";
        
        
        
         $txt_cash = "BAR";
    $txt_online = "ONLINE";

    $txt_pos = "KASSE";
    $txt_website = "WEBSEITE";
    $txt_app = "APP";

$txt_pickup_cash_delivery_cash = "Abholung Bar / Lieferung Bar / Vor Ort Bar";
$txt_pickup_online_delivery_online = "Abholung Online / Lieferung Online / Vor Ort Online";

$txt_pickup_cash_delivery_cash_2 = "Abholung Bar / Lieferung Bar";
$txt_pickup_online_delivery_online_2 = "Abholung Online / Lieferung Online";
    
    

} else {

    $txt_operational_overview = "Operational Overview";
    $txt_total_revenue = "Total Revenue";
    $txt_total_orders = "Total Orders";
    $txt_total_items = "Total Items";
    $txt_discount = "Discount";
    $txt_shipping = "Shipping";

    $txt_sales_channels = "Sales Channels (Platforms)";
    $txt_sum_orders = "Sum of Orders";

    $txt_payment_methods = "Payment Methods";

    $txt_cash = "CASH";
    $txt_online = "ONLINE";
    $txt_pickup_delivery_cash = "Pickup Cash / Delivery Cash";
    $txt_pickup_delivery_online = "Pickup Online / Delivery Online";

    $txt_tax_summary = "Tax Details & Summary";
    $txt_tax7_total = "7% Total (Incl. Tax)";
    $txt_tax19_total = "19% Total (Incl. Tax)";
    $txt_tax7 = "Tax 7%";
    $txt_tax19 = "Tax 19%";
    $txt_total_tax = "Total Tax";

    $txt_cash_vat = "CASH VAT";
    $txt_online_vat = "ONLINE VAT";

    $txt_total_cash_vat = "Total Cash VAT";
    $txt_total_online_vat = "Total Online VAT";

    $txt_performed_on = "Performed on";
    
        $txt_total_tax = "TOTAL TAX";
        
          $txt_online_vat = "ONLINE VAT";
    $txt_cash_vat   = "CASH VAT";
    
      $txt_total_cash_vat = "Total Cash VAT";
    $txt_total_online_vat = "Total Online VAT";
    
    
     $txt_total_revenue_label = "TOTAL REVENUE";
     
     
     $txt_cash = "CASH";
    $txt_online = "ONLINE";

    $txt_pos = "POS";
    $txt_website = "WEBSITE";
    $txt_app = "APP";

    $txt_pickup_cash_delivery_cash = "Pickup Cash / Delivery Cash / Dine-In Cash";
    $txt_pickup_online_delivery_online = "Pickup Online / Delivery Online / Dine-In Online";
    
    $txt_pickup_cash_delivery_cash_2 = "Pickup Cash / Delivery Cash";
    $txt_pickup_online_delivery_online_2 = "Pickup Online / Delivery Online";
}
$favicon = $BASE_URL . "/logo.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <link rel="icon" type="image/png" href="<?php echo htmlspecialchars($favicon); ?>">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars($favicon); ?>">
    <link rel="apple-touch-icon" href="<?php echo htmlspecialchars($favicon); ?>">
    <title>Z-Report - <?php echo htmlspecialchars($APP_NAME); ?></title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm;
            background-color: #ffffff;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000000;
            font-size: 10pt;
            line-height: 1.4;
        }
        .z-report {
            max-width: 600px;
            margin: 0 auto;
            padding: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .divider {
            border-top: 1px solid #000000;
            margin: 10px 0;
        }
        .double-divider {
            border-top: 3px double #000000;
            margin: 15px 0;
        }
        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin-top: 20px;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #000000;
            border-bottom: 2px solid #000000;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        td {
            padding: 4px 0;
            vertical-align: top;
        }
        .indent {
            padding-left: 20px;
        }
        .indent-2 {
            padding-left: 40px;
        }
        .tax-table td {
            font-size: 9.5pt;
        }
        .table-stripe {
            background-color: #f2f2f2;
        }
        
        .dotted-divider {
    border-top: 1px dotted #000;
    margin: 12px 0;
}
    </style>
</head>
<body>

<div class="z-report">
    <div class="text-center bold" style="font-size: 16pt; color: #000000;">Z-REPORT (Z-BERICHT)</div>
    <div class="text-center" style="font-size: 9.5pt; color: #000000; margin-bottom: 5px;">
        <?php echo $startDate; ?> - <?php echo $endDate; ?><br>
      <?php echo $txt_performed_on; ?>: <?php echo $genDate; ?>
    </div>
    
    <div class="text-center bold" style="font-size: 13pt; margin-top: 10px; color: #000000;"><?php echo $APP_NAME ?></div>
    <div class="text-center" style="font-size: 9pt; color: #000000;">
       <?php echo $company_address ?> | Tel. <?php echo $company_phone ?> 
    </div>

    <div class="double-divider"></div>

<div class="section-title"><?php echo $txt_operational_overview; ?></div>

<table>
    <tr>
<td><?php echo $txt_total_revenue; ?>:</td>
        <td class="text-right bold">
            <?php echo number_format($report['report_summary']['total_revenue'], 2); ?> €
        </td>
    </tr>

    <tr>
<td><?php echo $txt_total_orders; ?>:</td>
        <td class="text-right">
            <?php echo $report['report_summary']['total_orders']; ?>
        </td>
    </tr>

    <tr>
<td><?php echo $txt_total_items; ?>:</td>
        <td class="text-right">
            <?php echo $report['report_summary']['total_items']; ?>
        </td>
    </tr>

    <tr>
<td><?php echo $txt_discount; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['discount'], 2); ?> €
        </td>
    </tr>

    <tr>
<td><?php echo $txt_shipping; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['shipping'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td>7% Total:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['7_percent_total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td>19% Total:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['19_percent_total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td>Tax 7%:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['tax_7'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td>Tax 19%:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['tax_19'], 2); ?> €
        </td>
    </tr>
</table>

   <div class="section-title"><?php echo $txt_sales_channels; ?></div>

<table>
    <tr>
<td><?php echo $txt_sum_orders; ?></td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['total_revenue'], 2); ?> €
        </td>
    </tr>
</table>

<div class="divider"></div>

<table>
    <tr class="bold" style="font-size:13pt;">
     <td><?php echo $txt_total_revenue_label; ?></td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['total_revenue'], 2); ?> €
        </td>
    </tr>
</table>

<div class="section-title"><?php echo $txt_payment_methods; ?></div>

<table>
    <tr class="bold">
        <td style="padding-left:5px;">
            <?php echo $txt_cash; ?> (<?php echo $txt_pos; ?>):
        </td>
        <td class="text-right" style="padding-right:5px;">
            <?php echo number_format($report['platforms']['pos']['cash']['total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td class="indent">
            <?php echo $txt_pickup_cash_delivery_cash; ?>:
        </td>
        <td class="text-right">
           <?php echo number_format($report['platforms']['pos']['cash']['pickup'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['pos']['cash']['delivery'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['pos']['cash']['dinein'], 2); ?> €
        </td>
    </tr>

    <tr class="bold">
        <td style="padding-left:5px;">
            <?php echo $txt_online; ?> (<?php echo $txt_pos; ?>):
        </td>
        <td class="text-right" style="padding-right:5px;">
            <?php echo number_format($report['platforms']['pos']['online']['total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td class="indent">
            <?php echo $txt_pickup_online_delivery_online; ?>:
        </td>
        <td class="text-right">
           <?php echo number_format($report['platforms']['pos']['online']['pickup'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['pos']['online']['delivery'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['pos']['online']['dinein'], 2); ?> €
        </td>
    </tr>
</table>

<div class="dotted-divider"></div>

<table>
    <tr class="bold">
        <td style="padding-left:5px;">
            <?php echo $txt_cash; ?> (ONLINE CHANNELS):
        </td>
        <td class="text-right" style="padding-right:5px;">
            <?php echo number_format($report['platforms']['online']['cash']['total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td class="indent">
            <?php echo $txt_pickup_cash_delivery_cash_2; ?>:
        </td>
        <td class="text-right">
            <?php echo number_format($report['platforms']['online']['cash']['pickup'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['online']['cash']['delivery'], 2); ?> €
        </td>
    </tr>

    <tr class="bold">
        <td style="padding-left:5px;">
            <?php echo $txt_online; ?> (ONLINE CHANNELS):
        </td>
        <td class="text-right" style="padding-right:5px;">
            <?php echo number_format($report['platforms']['online']['online']['total'], 2); ?> €
        </td>
    </tr>

    <tr>
        <td class="indent">
            <?php echo $txt_pickup_online_delivery_online_2; ?>:
        </td>
        <td class="text-right">
            <?php echo number_format($report['platforms']['online']['online']['pickup'], 2); ?> €
            |
            <?php echo number_format($report['platforms']['online']['online']['delivery'], 2); ?> €
        </td>
    </tr>
</table>

<div class="section-title"><?php echo $txt_tax_summary; ?></div>

<table class="tax-table">

    <tr>
<td><?php echo $txt_tax7_total; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['7_percent_total'], 2); ?> €
        </td>
    </tr>

    <tr>
     <td><?php echo $txt_tax7; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['tax_7'], 2); ?> €
        </td>
    </tr>

    <tr>
       <td><?php echo $txt_tax19_total; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['19_percent_total'], 2); ?> €
        </td>
    </tr>

    <tr>
<td><?php echo $txt_tax19; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['report_summary']['tax_19'], 2); ?> €
        </td>
    </tr>

    <tr class="bold">
  <td><?php echo $txt_total_tax; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['total_tax'], 2); ?> €
        </td>
    </tr>

</table>

<div class="divider"></div>

<div class="bold" style="font-size: 9.5pt;">
       <?php echo $txt_cash_vat; ?>
</div>

<table class="tax-table">
    <tr>
       <td><?php echo $txt_tax19; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['cash']['tax_19'], 2); ?> €
        </td>
    </tr>

    <tr>
    <td><?php echo $txt_tax7; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['cash']['tax_7'], 2); ?> €
        </td>
    </tr>

    <tr class="bold">
      <td><?php echo $txt_total_cash_vat; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['cash']['total'], 2); ?> €
        </td>
    </tr>
</table>

<div class="divider"></div>

<div class="bold" style="font-size: 9.5pt;">
    <?php echo $txt_online_vat; ?>

</div>

<table class="tax-table">
    <tr>
        <td><?php echo $txt_tax19; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['online']['tax_19'], 2); ?> €
        </td>
    </tr>

    <tr>
         <td><?php echo $txt_tax7; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['online']['tax_7'], 2); ?> €
        </td>
    </tr>

    <tr class="bold">
    <td><?php echo $txt_total_online_vat; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['online']['total'], 2); ?> €
        </td>
    </tr>
</table>

<div class="double-divider"></div>

<table style="font-size:11pt;">
    <tr class="bold" style="font-size:13pt;">
      <td><?php echo $txt_total_tax; ?>:</td>
        <td class="text-right">
            <?php echo number_format($report['tax_summary']['total_tax'], 2); ?> €
        </td>
    </tr>
</table>
</div>

</body>
</html>