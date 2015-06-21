<div id="alertModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
$('form[method=post]').submit(function (e) {
    e.preventDefault();
    var postData = $(this).serializeArray(),
        self = this,
        submitText = $('[type=submit]').text(),
        fn = arguments.callee,
        alertModal = $('#alertModal');
    $(this).unbind('submit', fn);
    $(this).find('[type=submit]').text('请稍等...').attr('disabled', true);
    $.post($(this).attr('action') || location.href, postData, function (res) {
        $(self).find('[type=submit]').text(submitText).removeAttr('disabled');
        $(self).bind('submit', fn);
        alertModal.find('.modal-body').text(res.message);
        alertModal.modal('show');
        if (res.success) {
            setTimeout(function () {
                alertModal.modal('hide');
                res.redirect && location.replace(res.redirect);
            }, 1000);
        }
    }, 'json');
});
</script>