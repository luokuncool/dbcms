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
        <div class="col-md-6">
            <form role="form" method="post" action="">
                <div class="form-group">
                    <label>操作代码</label>
                    <input type="text" name="code" value="{{$data.code}}" class="form-control" placeholder="输入操作代码">
                </div>
                <div class="form-group">
                    <label>名称</label>
                    <input type="text" class="form-control" value="{{$data.name}}"  name="name" placeholder="请输入节点名称">
                </div>
                <div class="form-group">
                    <label>所属模块</label>
                    <select class="form-control" name="module">
                        {{foreach $modules as $module}}
                            <option {{if $module['module'] == $data['module']}}selected{{/if}}>{{$module.module}}</option>
                        {{/foreach}}
                    </select>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" id="newModuleInput" placeholder="请输入模块名称">
                    <div class="input-group-btn">
                        <button type="button" id="createModuleBtn" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <b>作为菜单</b>
                        <label>
                            <input type="radio" name="isMenu" value="1" class="minimal" {{if $data['isMenu']}}checked{{/if}}/> 是
                        </label>
                        <label>
                            <input type="radio" name="isMenu" value="0" class="minimal" {{if !$data['isMenu']}}checked{{/if}}/> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>菜单分组</label>
                    <select class="form-control" name="groupId">
                        <option value="">--请选择所属菜单组--</option>
                        {{foreach $node_group_list as $node_group}}
                            <option value="{{$node_group@key}}" {{if $node_group@key == $data.groupId}}selected{{/if}}>{{$node_group.groupName}}</option>
                        {{/foreach}}
                    </select>
                </div>
                <div class="form-group">
                    <label>图标Class</label>
                    <input type="text" class="form-control" value="{{$data.iconCls|default:'fa-circle-o'}}"  name="iconCls" placeholder="请输入图标Class">
                </div>
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
{{/block}}
{{block name="scripts"}}
    {{include file="../includes/submit_form.tpl"}}
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
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
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
            $('[name=module]').append('<option>'+newModuleName+'</option>').val(newModuleName);
        });
    });
    </script>
{{/block}}