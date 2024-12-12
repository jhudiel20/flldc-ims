<div class="modal fade" id="delete_room_photo_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"> Are you sure you want to
                        delete a photo?</i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <form method="post" id="delete_room_photo_form" style="display: inline-block;">
                    <input type="hidden" name="ID" id="ID" value="<?php echo $id ?>">
                    <input type="hidden" name="room_id" id="room_id" value="<?php echo $row['room_id'] ?>">
                    <input type="hidden" name="room_name" id="room_name" value="<?php echo $row['room_name'] ?>">
                    <input type="hidden" name="item_to_delete" id="item_to_delete" class="form-control" value="<?php echo $row['room_photo']; ?>">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="delete_room_photo_btn" class="btn btn-danger btn-page-block" >Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>