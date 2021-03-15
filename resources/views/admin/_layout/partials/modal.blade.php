<form action='' method='post' class="modal fade" id="custom-modal">
    @csrf
    <input type="hidden" name='id' value=''>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p data-modal-body='text'></p>
                <strong data-modal-body='name'></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-danger"></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

