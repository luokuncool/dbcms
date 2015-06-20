{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>账户列表</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}/user/index">账户管理</a></li>
        <li class="active">账户列表</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>角色名称</th>
                                <th>备注</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{foreach $list.rows as $role}}
                                <tr>
                                    <td>
                                        <input type="checkbox" name="roles[{{$role.id}}]" id="role{{$role.id}}" value="{{$role.id}}" class="minimal"
                                               {{if in_array($role['id'], $roleIds)}}checked{{/if}}/>
                                    </td>
                                    <td><label for="role{{$role.id}}">{{$role.name}}</label></td>
                                    <td>{{$role.remark}}</td>
                                    <td>{{$role.createTime|date_format:'Y-m-d'}}</td>
                                </tr>
                            {{/foreach}}
                            <tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>角色名称</th>
                                <th>备注</th>
                                <th>创建时间</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.box -->
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
{{/block}}
{{block name="scripts"}}
    {{include file="../includes/submit_form.tpl"}}
    <!-- DATA TABES SCRIPT -->
    <script src="/static/third/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/static/third/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="/static/third/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/static/third/plugins/fastclick/fastclick.min.js'></script>
    <!-- iCheck 1.0.1 -->
    <script src="/static/third/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
    $(function () {
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
    </script>
{{/block}}