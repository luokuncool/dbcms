{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>{{$data.name}} - 授权</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}/role/index">角色管理管理</a></li>
        <li class="active">角色授权</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" action="">
                <div class="checkbox">
                    <input type="checkbox" id="checkAll" class="square"/>
                    <label for="checkAll">全选</label>
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
                                    <input name="nodeIds[{{$node.id}}]" type="checkbox" class="square"
                                           id="node-{{$node.id}}" {{if in_array($node.id, $nodeIds)}}checked{{/if}}>
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
    {{include file="../includes/submit_form.tpl"}}
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

        $('#checkAll').on('ifChecked', function () {
            $('input[type=checkbox]').iCheck('check');
        }).on('ifUnchecked', function () {
            $('input[type=checkbox]').iCheck('uncheck');
        });

        $('.form-group input[type=checkbox]').on('ifChecked', function () {
            $(this).parents('.form-group').next().find('input[type=checkbox]').iCheck('check');
        }).on('ifUnchecked', function () {
            $(this).parents('.form-group').next().find('input[type=checkbox]').iCheck('uncheck');
        });
    });
    </script>
{{/block}}