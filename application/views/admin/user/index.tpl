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
            <div class="box">
                <div class="box-header">
                    <a href="{{$baseURL}}/user/create" class="btn btn-primary pull-right" role="button">添加</a>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>登陆名</th>
                            <th>账户名称</th>
                            <th>最近登陆时间</th>
                            <th>创建时间</th>
                            <th>用户状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{foreach $list.rows as $user}}
                            <tr>
                                <td>{{$user.uName}}</td>
                                <td>{{$user.name}}</td>
                                <td>{{$user.lastLoginTime|date_format:'Y-m-d'}}</td>
                                <td>{{$user.createTime|date_format:'Y-m-d'}}</td>
                                <td>
                                    {{if $user['status'] == 1}}
                                        <i class="text-green">启用</i>
                                    {{else}}
                                        <i class="text-red">禁用</i>
                                    {{/if}}
                                </td>
                                <td>
                                    <a href="{{$baseURL}}/user/edit/{{$user.id}}" title="编辑"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{$baseURL}}/user/set_role/{{$user.id}}" title="设置角色"><i class="fa fa-group"></i></a>&nbsp;&nbsp;
                                    <a href="{{$baseURL}}/user/remove/?ids={{$user.id}}" title="删除"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        {{/foreach}}
                        <tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>登陆名</th>
                            <th>账户名称</th>
                            <th>最近登陆时间</th>
                            <th>创建时间</th>
                            <th>用户状态</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{widget path="admin/widget/tools/pagination" args=$pagination}}
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
{{/block}}
{{block name="stylesheets"}}
    <!-- DATA TABLES -->
    <link href="/static/third/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
{{/block}}
{{block name="scripts"}}
    <!-- DATA TABES SCRIPT -->
    <script src="/static/third/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/static/third/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="/static/third/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/static/third/plugins/fastclick/fastclick.min.js'></script>
    <!-- page script -->
    <script type="text/javascript">
    $(function () {

    });
    </script>
{{/block}}