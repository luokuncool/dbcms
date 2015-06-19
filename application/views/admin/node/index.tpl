{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>节点列表</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}">节点管理</a></li>
        <li class="active">节点列表</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button class="btn btn-primary pull-right">添加节点</button>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>操作代码</th>
                            <th>节点名称</th>
                            <th>所属模块</th>
                            <th>所属菜单</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{foreach $nodes as $node}}
                            <tr>
                                <td>{{$node.code}}</td>
                                <td>{{$node.name}}</td>
                                <td>{{$node.module}}</td>
                                <td>{{$node.menuName}}</td>
                                <td>
                                    <a href="{{$baseURL}}/node/edit/{{$node.id}}" title="编辑"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a href="{{$baseURL}}/node/delete/{{$node.id}}" title="删除"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        {{/foreach}}
                        <tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>操作代码</th>
                            <th>节点名称</th>
                            <th>所属模块</th>
                            <th>节点类型</th>
                            <th>是否菜单</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
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