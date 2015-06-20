{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>节点编辑</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}/node/index">节点管理</a></li>
        <li class="active">节点编辑</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" action="">
                <div class="form-group">
                    <div class="checkbox">
                        <input type="checkbox" id="checkAll" class="square" />
                        <label for="checkAll">全选</label>
                    </div>
                </div>
                {{foreach $moduleTree as $nodes}}
                    <div class="form-group">
                        <div class="checkbox">
                            <input type="checkbox" id="{{$nodes@key}}" value="1" class="square"
                                   {{if $data['isMenu']}}checked{{/if}}/>
                            <label for="{{$nodes@key}}">{{$nodes@key}}</label>
                        </div>
                    </div>
                    <div class="checkbox">
                        <div class="box">
                            <div class="box-body">
                                {{foreach $nodes as $node}}
                                    <input name="nodeIds[{{$node.id}}]" type="checkbox" class="square" id="node-{{$node.id}}" {{if in_array($node.id, $nodeIds)}}checked{{/if}}>
                                    <label for="node-{{$node.id}}"> {{$node.name}}</label>
                                {{/foreach}}
                            </div>
                        </div>
                    </div>
                {{/foreach}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
{{/block}}
{{block name="stylesheets"}}
    <!-- DATA TABLES -->
    <link href="/static/third/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="/static/third/plugins/iCheck/all.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
    .checkbox label {
        font-size: 13px;
        min-height: 18px;
        padding: 0 10px;
    }
    </style>
{{/block}}
{{block name="scripts"}}
    <div id="alertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">提示框</h4>
                </div>
                <div class="modal-body"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- DATA TABES SCRIPT -->
    <script src="/static/third/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/static/third/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="/static/third/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- iCheck 1.0.1 -->
    <script src="/static/third/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/static/third/plugins/fastclick/fastclick.min.js'></script>
    <!-- page script -->
    <script type="text/javascript">
    $(function () {
        $('input[type="checkbox"].square, input[type="radio"].square').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'icheckbox_minimal-blue'
        });
        $('#createModuleBtn').click(function () {
            var newModuleInput = $('#newModuleInput'),
                newModuleName = newModuleInput.val();
            if (newModuleName == '') {
                newModuleInput.focus();
                return;
            }
            var exist = false;
            $('[name=module] option').each(function () {
                if ($(this).text() == newModuleName) {
                    exist = true;
                }
            });
            if (exist) {
                $('[name=module]').val(newModuleName);
                return;
            }
            $('[name=module]').append('<option>' + newModuleName + '</option>').val(newModuleName);
        });

        $('form[method=post]').submit(function (e) {
            e.preventDefault();
            var postData = $(this).serializeArray(),
                self = this,
                submitText = $('[type=submit]').text(),
                fn = arguments.callee;
            $(this).unbind('submit', fn);
            console.log(postData);
            $(this).find('[type=submit]').text('请稍等...').attr('disabled', true);
            $.post($(this).attr('action') || location.href, postData, function (res) {
                $(self).find('[type=submit]').text(submitText).removeAttr('disabled');
                $(self).bind('submit', fn);
                if (res.success) {
                    //location.reload();
                    return;
                }
                $('#alertModal .modal-body').text(res.message);
                $('#alertModal').modal('show');
            }, 'json');
        });
    });
    </script>
{{/block}}