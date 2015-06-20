{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>角色列表</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}/role/index">角色管理</a></li>
        <li class="active">角色列表</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{$baseURL}}/node/create" class="btn btn-primary pull-right" role="button">添加</a>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>角色名称</th>
                            <th>角色状态</th>
                            <th>创建时间</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{foreach $list.rows as $role}}
                            <tr>
                                <td>{{$role.name}}</td>
                                <td>{{$role.status}}</td>
                                <td>{{$role.createTime|date_format:'Y-m-d'}}</td>
                                <td>{{$role.remark}}</td>
                                <td>
                                    <a href="{{$baseURL}}/role/edit/{{$role.id}}" title="编辑"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{$baseURL}}/role/remove/?ids={{$role.id}}" title="删除"><i class="fa fa-trash"></i></a>
                                    &nbsp;&nbsp;
                                    <a href="{{$baseURL}}/role/set_rights/{{$role.id}}" title="授权">授权</a>
                                </td>
                            </tr>
                        {{/foreach}}
                        <tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>角色名称</th>
                            <th>角色状态</th>
                            <th>创建时间</th>
                            <th>备注</th>
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