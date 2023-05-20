<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="pg-title pt-5">
                <h2>
                    List Invoices
                </h2>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover client-list-table" id="invoices-tables">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sr no </th>
                            <th>Client Name</th>
                            <th>Invoice Dated</th>
                            <th>Invoice Number</th>
                            <th>Service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $invoices = $invoice->get_all_Invoices();
                            // print_r($invoices);
                            $sr_no = 0;
                            foreach($invoices as $invoice)
                            {
                        ?>
                        <tr>
                            <td>
                            <?php
                                echo $sr_no = $sr_no+1;
                            ?>
                            </td>
                            <td>
                                <?php
                                $client_name = $client->get_client_name_by_id($invoice['client_id']);
                                    print_r($client_name);
                                ?>
                            </td>
                            <td><?php echo $invoice['performa-date']?></td>
                            <td><?php echo $invoice['invoice_universal_number']?></td>
                            <td><?php echo $invoice['performa-service']?></td>
                            <td>
                            <a href="<?php echo ROOT_URL .'invoice/invoice-pdf.php?id='.$invoice['uniqueID'].'&client-id='.$invoice['client_id']; ?>&trigger=download" class="btn btn-outline-success download" id="download"><i class="fa-duotone fa-download"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>