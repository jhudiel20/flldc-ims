
<style>
    #shippingFeeInput {
    transition: opacity 0.5s ease-in-out;
    opacity: 0;
}
</style>
<div class="modal fade" id="pay_modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" id="proceed_payment_form">

                    <div class="tab-pane fade show active" id="user" role="tabpanel">
                        <div class="row">
                        <?php foreach ($_SESSION['selected_items'] as $selected_item) { ?>
                            <input type="hidden" name="product_id[]" id="product_id[]" value="<?php echo $selected_item['product_code'];?>">
                            <input type="hidden" name="quantity[]" id="quantity[]" value="<?php echo $selected_item['quantity']; ?>">
                        <?php } ?>
                            <div class="form-message alert alert-danger" role="alert"></div>
                            <div class="form-group row text-left mb-2">
                            <input type="hidden" name="remarks" id="remarks">
                                <div class="col-sm-12 text-center">
                                    <h3 class="py-0">
                                        Are you sure you want to proceed ?
                                    </h3>
                                </div>

                            </div>
                        
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="submit_proceed_payment" class="btn btn-outline-primary" id="submit_proceed_payment">Submit</button>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
            </div>
            </form><!-- End Multi Columns Form -->
        </div>
    </div>
</div>
