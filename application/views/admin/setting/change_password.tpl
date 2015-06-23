{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>密码修改</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="#">个人设置</a></li>
        <li class="active">密码修改</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-6">
            <form role="form" method="post" action="">
                <div class="form-group">
                    <label>旧密码 <i class="text-red">*</i></label>
                    <input type="password" name="oldPassword" value="{{$data.code}}" class="form-control"
                           placeholder="输入旧密码">
                </div>
                <div class="form-group">
                    <label>新密码 <i class="text-red">*</i></label>
                    <input type="password" class="form-control" value="{{$data.name}}" name="password"
                           placeholder="请输入新密码">
                </div>
                <div class="form-group">
                    <label>确认密码 <i class="text-red">*</i></label>
                    <input type="password" class="form-control" value="{{$data.name}}" name="rePassword"
                           placeholder="请再次输入新密码">
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
    <!-- Theme style -->
    <link href="/static/third/plugins/iCheck/all.css" rel="stylesheet" type="text/css"/>
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
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
    </script>
{{/block}}