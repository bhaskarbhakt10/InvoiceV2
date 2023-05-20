<?php
$edit = false;
if (array_key_exists('page', $_GET) && $_GET['page'] === 'invoice-edit-clients' && array_key_exists('client-id', $_GET)) {
    $client_id = $_GET['client-id'];
    $edit_client = $client->get_client_details_by_id($client_id);
    $editdetails = json_decode($edit_client['InvoiceClient_Info'], true);
    print_r($editdetails);
    $edit = true;
} else if (array_key_exists('page', $_GET) && $_GET['page'] === 'invoice-clients') {
} else {
    echo "Seems like you lost your path";
    // header('Location: '. ROOT_PATH);
    exit();
}

?>

<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10 py-5">
        <div class="pg-title">
            <h2 class="">Add Client Details</h2>
        </div>
        <?php
        if ($edit === true) {
        ?>
            <span id="client-id" data-client-id="<?php echo $edit_client['InvoiceClient_ID'] ?>"></span>
        <?php
        }
        ?>
        <span id="edit-add-flag" data-edit-add-flag="<?php echo $edit===true? 'true' : 'false'; ?>"></span>
        <form action="<?php echo $edit === true ?  ROOT_URL_ACTION . 'edit-client.php' : ROOT_URL_ACTION . 'add-client.php'; ?>" method="POST" class="form" id="<?php echo $edit === true ? 'edit' : 'add' ?>-client-form">
            <fieldset class="invoice-clients">
                <div class="form-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="client-name" class="form-label"> Client Name</label>
                                <input type="text" name="client-name" id="client-name" class="form-control form-field" required placeholder="Client Name" <?php echo $edit === true && !empty($editdetails['client-name']) ? 'value="' . $editdetails['client-name'] . '"' : ''; ?>>
                            </div>
                            <div class="col-md-12">
                                <p class="subform-heading">Address</p>
                                <div class="address-decision mb-3">
                                    <div class="d-flex flex-wrap gap-10">
                                        <div class="d-flex">
                                            <input type="checkbox" name="textbox-usage" id="use-text-box-no" value="no" <?php echo $edit === false ? 'checked' : ''; ?> class="form-check-input form-field" <?php echo $edit === true && $editdetails['textbox-usage'] === "no" ? 'checked' : ''; ?>>
                                            <label for="use-text-box-no">Using api</label>
                                        </div>
                                        <div class="d-flex">
                                            <input type="checkbox" name="textbox-usage" id="use-text-box-yes" value="yes" class="form-check-input form-field" <?php echo $edit === true && $editdetails['textbox-usage'] === "yes" ? 'checked' : ''; ?>>
                                            <label for="use-text-box-yes">I want to use text box</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="address-box" id="address-box">
                                    <div class="address-wrapper" data-ref="use-text-box-no">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="address-line-one" class="form-label">Address</label>
                                                <input type="text" name="address-line-one" id="address-line-one" placeholder="Address Line 1" class="form-control form-field" required <?php echo $edit === true&& !empty($editdetails['address-line-one']) ? 'value="' . $editdetails['address-line-one'] . '"' : ''; ?>>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="address-line-two" class="form-label">Address Line 2</label>
                                                    <input type="text" name="address-line-two" id="address-line-two" class="form-control form-field" required <?php echo $edit === true  && !empty($editdetails['address-line-two']) ? 'value="' . $editdetails['address-line-two'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address-country" class="form-label">Select a Country</label>
                                                    <select name="address-country" id="address-country" class="form-select form-field " required>
                                                        <?php if ($edit === true && !empty($editdetails['address-country'])) { ?> <option selected value="<?php echo $editdetails['address-country']; ?>"><?php echo $editdetails['address-country']; ?></option><?php } ?>
                                                        <option value="">Select an country</option>
                                                        <option value="">India</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address-country-state" class="form-label">Select a State</label>
                                                    <select name="address-country-state" id="address-country-state" class="form-select form-field" required>
                                                        <?php if ($edit === true && !empty($editdetails['address-country-state'])) { ?> <option selected value="<?php echo $editdetails['address-country-state']; ?>"><?php echo $editdetails['address-country-state']; ?></option><?php } ?>
                                                        <option value="">please select a state</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($edit === true ) { ?>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div id="edit_select">
                                                    <label for="address-country-city" class="form-label">Select a City</label>
                                                    <select name="address-country-city" id="address-country-city" class="form-select form-field" required>
                                                        <?php if ($edit === true && $editdetails['address-country-city']) { ?> <option selected value="<?php echo $editdetails['address-country-city']; ?>"><?php echo $editdetails['address-country-city']; ?></option><?php } ?>
                                                        <option value="">please select a City</option>
                                                    </select>
                                                    </div>
                                                    <div class="d-flex gap-10 flex-column">
                                                        <div id="edit_check">
                                                            <input type="checkbox" name="input-city-check" id="input-city-check" class="form-check-input" <?php echo $edit === true  && array_key_exists('input-city-check',$editdetails) ? 'checked' : ''; ?>>
                                                            <label for="input-city-check">Can't find the city I'm looking for. Let me type</label>
                                                            <input type="text" name="input-city" id="input-city" class="form-control form-field" required <?php echo $edit === true && !empty($editdetails['input-city']) ? 'value="' . $editdetails['input-city'] . '"' : ''; ?>>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <?php } 
                                            else{
                                                ?>
                                                <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address-country-city" class="form-label">Select a City</label>
                                                    <select name="address-country-city" id="address-country-city" class="form-select form-field" required>
                                                        <option value="">please select a City</option>
                                                    </select>
                                                    <div class="d-flex gap-10 flex-column">
                                                        <div>
                                                            <input type="checkbox" name="input-city-check" id="input-city-check" class="form-check-input">
                                                            <label for="input-city-check">Can't find the city I'm looking for. Let me type</label>
                                                            <input type="text" name="input-city" id="input-city" class="form-control form-field" required >
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="postal-code" class="form-label">Postal Code</label>
                                                    <input type="text" name="postal-code" id="postal-code" class="form-control form-field" required <?php echo $edit === true && !empty($editdetails['postal-code']) ? 'value="' . $editdetails['postal-code'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="address-text" data-ref="use-text-box-yes">
                                        <div class="text-address mb-3">
                                            <label for="" class="form-label">Input address</label>
                                            <textarea name="text-address-box" id="text-address-box" cols="30" rows="2" class="form-control form-field" required placeholder="Use <br> to break the address into multiple lines "><?php echo $edit===true && !empty($editdetails['text-address-box']) ? $editdetails['text-address-box'] : '' ;?></textarea>
                                        </div>
                                    </div>
                                    <div class="address-tax" id="address-tax">
                                        <div class="row" id="tax-row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="d-flex w-100 gap-10">
                                                        <div class="w-25">
                                                            <label for="address-country-code" class="form-label">Country Code</label>
                                                            <input type="text" name="address-country-code" id="address-country-code" class="form-control form-field" placeholder="+91" required <?php echo $edit === true ? 'value="' . $editdetails['address-country-code'] . '"' : ''; ?> />
                                                        </div>
                                                        <div class="w-100">
                                                            <label for="client-phone-number" class="form-label">Phone Number</label>
                                                            <input type="tel" name="client-phone-number" id="client-phone-number" class="form-control form-field" placeholder="0123 456 789" required <?php echo $edit === true ? 'value="' . $editdetails['client-phone-number'] . '"' : ''; ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="client-email" class="form-label">Email address</label>
                                                    <input type="email" name="client-email" id="client-email" class="form-control form-field" placeholder="jhom@gmail.com" <?php echo $edit === true && !empty($editdetails['client-email']) ?  'value="' . $editdetails['client-email'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="CGST">CGST</label>
                                                    <input type="text" name="CGST" id="CGST" class="form-control form-field" required readonly <?php echo $edit === true && !empty($editdetails['CGST']) ?  'value="' . $editdetails['CGST'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="SGST">SGST</label>
                                                    <input type="text" name="SGST" id="SGST" class="form-control form-field" required readonly <?php echo $edit === true && !empty($editdetails['SGST']) ?  'value="' . $editdetails['SGST'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="IGST">IGST</label>
                                                    <input type="text" name="IGST" id="IGST" class="form-control form-field" required readonly <?php echo $edit === true && !empty($editdetails['IGST']) ?  'value="' . $editdetails['IGST'] . '"' : ''; ?>>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="country-currency">Currency</label>
                                                    <input type="text" name="country-currency" id="country-currency" class="form-control form-field" required readonly <?php echo $edit === true && !empty($editdetails['country-currency']) ?  'value="' . $editdetails['country-currency'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="gstin">
                                                <div class="mb-3">
                                                    <label for="client-gst" class="form-label">GSTIN</label>
                                                    <input type="text" name="client-gst" id="client-gst" class="form-control form-field" required placeholder="" required <?php echo $edit === true && !empty($editdetails['client-gst']) ? 'value="' . $editdetails['client-gst'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="submit-form btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>