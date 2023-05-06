<?php
$client_id = $_GET['client-id'];
$details = $client->get_client_details_by_id($client_id);
print_r($details);
$d = json_decode($details['InvoiceClient_Info'], true);
$cgst = $d['CGST'];
$sgst = $d['SGST'];
$igst = $d['IGST'];
$currency = $d['country-currency'];
$client_id_fromdb = $details['InvoiceClient_ID'];
?>


    <div class="form-wrapper">
        <form action="<?php echo ROOT_URL_ACTION . 'add-invoice.php'; ?>" method="POST" id="gen-invoice-form">
        <input type="hidden" name="client_id" value="<?php echo $client_id_fromdb; ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="performa-number" class="form-label">Perfoma Number</label>
                        <input type="text" name="performa-number" id="performa-number" class="form-control form-field" readonly value="<?php echo $invoice->generate_Performa_number($client_id_fromdb);?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="performa-number" class="form-label">Date</label>
                        <input type="text" name="performa-date" id="performa-date" class="form-control form-field datepicker" placeholder="DD/MM/YYYY">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="performa-service" class="form-label">Select a Service</label>
                        <select name="performa-service" id="performa-service" class="form-select form-field">
                            <option value="">None</option>
                            <option value="SMO">SMO</option>
                            <option value="SEO">SEO</option>
                            <option value="AMC">AMC</option>
                            <option value="MKT">MKT</option>
                            <option value="DHS">DHS</option>
                            <option value="ECOM">ECOM</option>
                            <option value="DES">DES</option>
                            <option value="WSD">WSD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="description-wrapper" id="details">
                        <table class="table">
                            <thead>
                                <th class="w-7">Sr No</th>
                                <th class="w-45">Description</th>
                                <th class="w-35">Price</th>
                                <th class="w-13">Actions</th>
                            </thead>
                            <tbody>
                                <tr class="details-row">
                                    <td>
                                        <span class="sr-no">1</span>
                                    </td>
                                    <td>
                                        <textarea name="description" id="description" cols="30" rows="1" class="form-control form-field"></textarea>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-field" name="price" id="price" value="0">
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-success add-row"><i class="fa-duotone fa-plus"></i></button>
                                        <button class="btn btn-outline-danger remove-row"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="discount-row">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <label for="discount" class="form-label">Discount</label>
                                        <input type="text" name="discount" id="discount" class="form-control form-field" value="0">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <label for="subtotal">Sub Total ( <?php echo $currency; ?> ) </label>
                                        <input type="text" name="subtotal" id="subtotal" class="form-control form-field" readonly value="0">
                                    </td>
                                    <td></td>
                                </tr>
                                <?php if (!empty($cgst) || !empty($sgst) || !empty($igst)) { ?>

                                    <tr class="discount-row">
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php if (!empty($cgst) && strcasecmp($cgst, "n/a") !== 0) { ?>
                                                <div class="d-flex gap-10 flex-wrap mb-3">
                                                    <div class="w-45">
                                                        <label for="CGST" class="form-label ">CGST</label>
                                                        <input type="text" name="CGST" id="CGST" class="form-control form-field" value="<?php echo $cgst; ?>" readonly>
                                                    </div>
                                                    <div class="w-45">
                                                        <label for="CGST-value" class="form-label ">CGST in <?php echo $currency; ?></label>
                                                        <input type="text" name="CGST-value" id="CGST-value" class="form-control form-field" value="0" readonly>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($sgst) && strcasecmp($sgst, "n/a") !== 0) { ?>
                                                <div class="d-flex gap-10 flex-wrap">
                                                    <div class="w-45">
                                                        <label for="SGST" class="form-label">SGST</label>
                                                        <input type="text" name="SGST" id="SGST" class="form-control form-field" value="<?php echo $sgst; ?>" readonly>
                                                    </div>
                                                    <div class="w-45">
                                                        <label for="SGST-value" class="form-label">SGST in <?php echo $currency; ?></label>
                                                        <input type="text" name="SGST-value" id="SGST-value" class="form-control form-field" value="0" readonly>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($igst) && strcasecmp($igst, "n/a") !== 0) { ?>
                                                <div class="d-flex gap-10 flex-wrap">
                                                    <div class="w-45">
                                                        <label for="IGST" class="form-label">IGST</label>
                                                        <input type="text" name="IGST" id="IGST" class="form-control form-field" value="<?php echo $igst; ?>" readonly>
                                                    </div>
                                                    <div class="w-45">
                                                        <label for="IGST-value" class="form-label">IGST in <?php echo $currency; ?></label>
                                                        <input type="text" name="IGST-value" id="IGST-value" class="form-control form-field" value="0" readonly>
                                                    </div>
                                            <?php } ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <label for="total">Total ( <?php echo $currency; ?> ) </label>
                                        <input type="text" name="total" id="total" class="form-control form-field" readonly value="0">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>