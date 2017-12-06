<div id="moveEventModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Move to room</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    Select Room
                    <select name="rooms" class="form-control input-sm">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button onclick="moveConfirm()" type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>