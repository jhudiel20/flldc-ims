<div class="modal fade" id="add_rca_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New RCA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_rca_form">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">

                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">NAME<span class="require asterisk">*</span></label>
                                <select name="employee" id="employee" class="form-select">
                                    <option value="" disabled hidden selected>Select Employee</option>
                                    <?php   $full_names = $conn->prepare("SELECT * FROM user_account");
                                            $full_names->execute();
                                            while ($row_full_names = $full_names->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option
                                        value="<?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>">
                                        <?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Employee No.<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="employee_no" id="employee_no"
                                    onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Paygroup<span class="require asterisk">*</span></label>
                                <select class="form-select" name="paygroup" id="paygroup" required>
                                    <option value="" disabled selected>Select Paygroup</option>
                                    <?php foreach (PAYGROUP as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">SBU<span class="require asterisk">*</span></label>
                                <select class="form-select" name="sbu" id="sbu" required>
                                    <option value="" disabled selected>Select SBU</option>
                                    <?php foreach (SBU as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="branch" id="branch">
                            </div>

                            <hr class="mt-4">
                            <div class="col-md-6">
                                <label class="form-label">Amount<span class="require asterisk">*</span></label>
                                <!-- <input type="text" class="form-control" name="amount" id="amount"> -->
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="amount" id="amount"
                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Payee Name<span class="require asterisk">*</span></label>
                                <select name="payee" id="payee" class="form-select">
                                    <option value="" disabled hidden selected>Please select</option>
                                    <?php   $full_names = $conn->prepare("SELECT * FROM user_account");
                                            $full_names->execute();
                                            while ($row_full_names = $full_names->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option
                                        value="<?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>">
                                        <?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account No.<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="account_no" id="account_no">
                            </div>
                            <div class="form-check col-md-3 pt-4">
                                <input class="form-check-input" type="checkbox" value="" id="non_travel" />
                                <label class="form-check-label" for=""> NON-TRAVEL </label>
                            </div>
                            <div class="form-check col-md-3 pt-4">
                                <input class="form-check-input" type="checkbox" value="" id="travel" />
                                <label class="form-check-label" for=""> TRAVEL </label>
                            </div>
                            <hr class="mt-4">
                            <div id="div_non_travel" style="display:none;">
                                <div class="col-md-12">
                                    <label class="form-label">Purpose of RCA<span
                                            class="require asterisk">*</span></label>
                                    <input type="text" class="form-control" name="purpose_rca" id="purpose_rca">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Date Needed<span class="require asterisk">*</span></label>
                                    <input type="date" class="form-control" name="date_needed" id="date_needed">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Date Event<span class="require asterisk">*</span></label>
                                    <input type="date" class="form-control" name="date_event" id="date_event">
                                </div>
                            </div>

                            <div id="div_travel" style="display:none;">
                                <div class="col-md-12">
                                    <label class="form-label">Purpose of Travel<span
                                            class="require asterisk">*</span></label>
                                    <input type="text" class="form-control" name="purpose_travel" id="purpose_travel">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Date of Departure<span
                                            class="require asterisk">*</span></label>
                                    <input type="date" class="form-control" name="date_depart" id="date_depart">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Date of Return<span
                                            class="require asterisk">*</span></label>
                                    <input type="date" class="form-control" name="date_return" id="date_return">
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <input type="date" class="form-control" name="date_needed" id="date_needed">
                            </div> -->
                            <div class="col-md-12">
                                <label class="form-label">Please Insert Receipts<span
                                        class="require asterisk">*</span></label>
                                <input type="file" class="form-control" name="receipt" id="receipt">

                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="submit" name="add_rca" class="btn btn-label-primary btn-page-block" id="add_rca">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>
<div class="modal fade" id="approval_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Select Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="request_approval_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <input type="hidden" id="ID" name="ID">
                            <input type="hidden" id="EMAIL" name="EMAIL">
                            <input type="hidden" id="ITEM_NAME" name="ITEM_NAME">
                            <input type="hidden" id="REQUEST_ID" name="REQUEST_ID">
                            <label for="nameWithTitle" class="form-label">Status</label>
                            <select name="approval_status" id="approval_status" class="form-select">
                                <option value="APPROVED">APPROVED</option>
                                <option value="DECLINED">DECLINED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-label-primary btn-page-block" id="submit_approval">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ########################################################################################################## -->

<div class="modal fade" id="add_pcv_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New PCV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="add_pcv_form">

                    <div class="tab-pane fade show active" id="USER" role="tabpanel">
                        <div class="row">
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="col-md-6">
                                <label class="form-label">SBU<span class="require asterisk">*</span></label>
                                <select class="form-select" name="sbu" id="sbu" required>
                                    <option value="" disabled selected>Select SBU</option>
                                    <?php foreach (SBU as $value) { ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">PCV NO.<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="pcv_no" id="pcv_no"
                                onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NAME<span class="require asterisk">*</span></label>
                                <select name="employee" id="employee" class="form-select">
                                    <option value="" disabled hidden selected>Select Employee</option>
                                    <?php   $full_names = $conn->prepare("SELECT * FROM user_account WHERE ACCESS != 'GUARD' ");
                                            $full_names->execute();
                                            while ($row_full_names = $full_names->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option
                                        value="<?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>">
                                        <?php echo $row_full_names['fname'].' '.$row_full_names['mname'].' '.$row_full_names['lname'].' '.$row_full_names['ext_name'];?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department<span class="require asterisk">*</span></label>
                                <input type="text" class="form-control" name="department" id="department" placeholder="Learning and Department Center">
                            </div>

                            <hr class="mt-4">
                            <div class="col-md-6">
                                <label class="form-label">Total Expenses<span class="require asterisk">*</span></label>
                                <!-- <input type="text" class="form-control" name="amount" id="amount"> -->
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control" name="expenses" id="expenses"
                                        onKeyPress="if(this.value.length==12) return false;return event.keyCode === 8 || (event.charCode >= 48 && event.charCode <= 57)"
                                        oninput="if(this.value!=''){this.value = parseFloat(this.value.replace(/,/g, '')).toLocaleString('en-US', {style: 'decimal', maximumFractionDigits: 0, minimumFractionDigits: 0})}">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date<span class="require asterisk">*</span></label>
                                <input type="date" class="form-control" name="pcv_date" id="pcv_date" >
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Site/Dept/Cost Center to Charge:</label>
                                <textarea type="text" class="form-control" name="sdcc" id="sdcc" cols="30" rows="5" ></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Justification/Remarks</label>
                                <textarea type="text" class="form-control" name="remarks" id="remarks" cols="30" rows="5" ></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Please Insert PCV<span
                                        class="require asterisk">*</span></label>
                                <input type="file" class="form-control" name="pcv_file" id="pcv_file">

                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-label-secondary">Reset</button>
                <button type="submit" name="submit" class="btn btn-label-primary btn-page-block" id="add_pcv" name="add_pcv">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>