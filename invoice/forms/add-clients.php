<div class="container">
    <form action="" method="POST">
        <fieldset>
            <div class="form-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="client-name" class="form-label"> Client Name</label>
                            <input type="text" name="client-name" id="client-name" class="form-control form-field" required placeholder="Client Name">
                        </div>
                        <div class="col-md-12">
                            <p class="subform-heading">Address</p>
                            <div class="address-decision">
                                <div class="d-flex flex-wrap gap-10">
                                    <div class="d-flex">
                                        <input type="checkbox" name="textbox-usage" id="use-text-box-no" checked class="form-check-input form-field">
                                        <label for="use-text-box-no">Using api</label>
                                    </div>
                                    <div class="d-flex">
                                        <input type="checkbox" name="textbox-usage" id="use-text-box-yes" class="form-check-input form-field">
                                        <label for="use-text-box-yes">I want to use text box</label>
                                    </div>
                                </div>
                            </div>
                            <div class="address-box" id="address-box">
                                <div class="address-wrapper" data-ref="use-text-box-no">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="address-line-one" class="form-label">Address Line 1</label>
                                            <input type="text" name="address-line-one" id="address-line-one" class="form-control form-field" required>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address-line-two" class="form-label">Address Line 2</label>
                                                <input type="text" name="address-line-two" id="address-line-two" class="form-control form-field" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address-country" class="form-label">Select a Country</label>
                                                <select name="address-country" id="address-country" class="form-select form-field " required>
                                                    <option value="">Select an country</option>
                                                    <option value="">India</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address-country-state" class="form-label">Select a State</label>
                                                <select name="address-country-state" id="address-country-state" class="form-select form-field" required>
                                                    <option value="">please select a state</option>
                                                </select>
                                            </div>
                                        </div>
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
                                                        <input type="text" name="input-city" id="input-city" class="form-control form-field" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="d-flex w-100 gap-10">
                                                    <div class="w-25">
                                                        <label for="address-country-code" class="form-label">Country Code</label>
                                                        <input type="text" name="address-country-code" id="address-country-code" class="form-control form-field" placeholder="+91" required />
                                                    </div>
                                                    <div class="w-100">
                                                        <label for="client-phone-number" class="form-label">Phone Number</label>
                                                        <input type="tel" name="client-phone-number" id="client-phone-number" class="form-control form-field" placeholder="0123 456 789" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="postal-code">Postal Code</label>
                                                <input type="text" name="postal-code" id="postal-code" class="form-control form-field" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="address-text" data-ref="use-text-box-yes">
                                    <div class="text-address mb-3">
                                        <label for="">Input address</label>
                                        <textarea name="text-address-box" id="text-address-box" cols="30" rows="10" class="form-control form-field" required></textarea>
                                    </div>
                                </div>
                                <div class="address-tax" id="address-tax">
                                    <div class="row" id="tax-row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="CGST">CGST</label>
                                                <input type="text" name="CGST" id="CGST" class="form-control form-field" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="SGST">SGST</label>
                                                <input type="text" name="SGST" id="SGST" class="form-control form-field" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="IGST">IGST</label>
                                                <input type="text" name="IGST" id="IGST" class="form-control form-field" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="country-currency">Currency</label>
                                                <input type="text" name="country-currency" id="country-currency" class="form-control form-field" required readonly>
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