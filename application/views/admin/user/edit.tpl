{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>系统用户编辑</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="{{$baseURL}}/user/index">系统用户管理</a></li>
        <li class="active">系统用户编辑</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-6">
            <form role="form" method="post" action="">
                <div class="form-group">
                    <label>登陆名 <i class="text-red">*</i></label>
                    <input type="text" name="uName" value="{{$data.uName}}" class="form-control" placeholder="请输入登陆名">
                </div>
                <div class="form-group">
                    <label>登陆密码 <i class="text-red">*</i></label>
                    <input type="password" class="form-control" value=""  name="password" placeholder="请输入登陆密码">
                </div>
                <div class="form-group">
                    <label>确认密码 <i class="text-red">*</i></label>
                    <input type="password" class="form-control" value=""  name="rePassword" placeholder="请输入登陆密码">
                </div>
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" name="name" value="{{$data.name}}" class="form-control" placeholder="请输入用户名">
                </div>
                <div class="form-group">
                    <label>电子邮箱</label>
                    <input type="text" name="email" value="{{$data.email}}" class="form-control" placeholder="请输入电子邮箱">
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <b>启用</b>
                        <label>
                            <input type="radio" name="status" value="1" class="minimal" {{if $data['status']}}checked{{/if}}/> 是
                        </label>
                        <label>
                            <input type="radio" name="status" value="0" class="minimal" {{if !$data['status']}}checked{{/if}}/> 否
                        </label>
                    </div>
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