<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 py-5">
            <div class="pg-title">
                    <h2 class="">Client Detail List</h2>
                </div>
                <div class="table-responsive">
                <table class="table table-striped table-hover client-list-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Serial No</th>
                            <th>Client Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $all_clients = $client->get_all_clients();
                        if(!empty($all_clients)){
                        if ($all_clients->num_rows > 0) {
                            while ($row = $all_clients->fetch_assoc()) {
                                // echo "<pre>";
                                // print_r($row);
                                // echo "</pre>";
                        ?>
                                <tr>
                                    <td><?php echo $row['InvoiceClient_SrNo']; ?></td>
                                    <td>
                                        <?php
                                        $client_info = $row['InvoiceClient_Info'];
                                        $client_arr = json_decode($client_info, true);
                                        echo $client_arr['client-name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $client_info = $row['InvoiceClient_Info'];
                                        $client_arr = json_decode($client_info, true);
                                        echo $client_arr['address-country-code'] . " " . $client_arr['client-phone-number'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $client_info = $row['InvoiceClient_Info'];
                                        $client_arr = json_decode($client_info, true);
                                        echo $client_arr['client-email'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $client_id = $row['InvoiceClient_ID'];
                                        $client_id_query = http_build_query(array(
                                            'client-id' => $row['InvoiceClient_ID']
                                        ));
                                        ?>
                                        <a class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Client" href="index.php?page=invoice-edit-clients&<?php echo $client_id_query; ?>"><i class="fa-duotone fa-pen-to-square"></i></a>
                                        <a class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Invoice" href="index.php?page=invoice-generate-perfoma&<?php echo $client_id_query; ?>"><i class="fa-duotone fa-file-invoice"></i></a>
                                        <a class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title=" View Proforma" href="index.php?page=invoice-list-proforma&<?php echo $client_id_query; ?>"><i class="fa-duotone fa-arrow-up-right-from-square"></i></a>
                                        <a class="btn btn-outline-danger delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Client" data-delete="<?php  echo $client_id; ?>"><i class="fa-duotone fa-trash"></i></a>
                                        <!-- <a class="btn btn-outline-danger delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Client" data-delete="<?php // echo $client_id; ?>"><i class="fa-duotone fa-trash"></i></a> -->
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                    }
                    else{
                        ?>
                        <tr>
                            <td colspan="5">No clients Found. Start  <a href="<?php echo NAVIGATION_URL .'invoice-clients' ?>">adding clients</a></td>
                        </tr>
                        <?php

                    }
                        ?>
                    </tbody>
                    <tfoot>
                        <input type="hidden" id="ajax_url" value="<?php echo ROOT_URL_ACTION . 'softdel.php' ?>">
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>
</section>