<?php
if (array_key_exists('client-id', $_GET)) {
    $client_id = $_GET['client-id'];
} else {
    exit();
}
$result = $invoice->get_all_Details_ByID($client_id);
?>
<table class="table">
    <thead>
        <tr>
            <th>Sr no </th>
            <th>Genrated On</th>
            <th>Perfoma Number</th>
            <th>Service</th>
            <th>Is Invoice ?</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sr_no = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $all_info = $row['invoiceInvoices_Info'];
            }
            $all_info_arr = json_decode($all_info, true);
            print_r($all_info_arr);
            foreach ($all_info_arr as $detail) {
        ?>
                <tr>
                    <td><?php echo $sr_no = $sr_no + 1; ?></td>
                    <td><?php echo $detail['genrated_at_date'] ?></td>
                    <td><?php echo $detail['performa-number'] ?></td>
                    <td><?php echo $detail['performa-service'] ?></td>
                    <td><?php echo $detail['is_invoice'] === 0 ? 'No' : 'Yes' ?></td>
                    <td>
                        <a href="<?php echo ROOT_URL .'invoice/invoice-pdf.php?id='.$detail['uniqueID'].'&client-id='.$detail['client_id'] ?>" class="btn btn-outline-warning" id="view-pdf"><i class="fa-duotone fa-file-pdf"></i></a>
                        <?php
                        if ($detail['is_invoice'] === 0) {
                        ?>
                            <a href="" class="btn btn-outline-primary" id="invoice"><i class="fa-duotone fa-file-invoice"></i></a>
                        <?php
                        } else {
                        ?>
                            <a href="" class="btn btn-outline-success" id="download"><i class="fa-duotone fa-download"></i></a>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
    <?php