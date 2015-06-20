{{extends file="../extends/layout.tpl"}}
{{block name="location"}}
    <h1>修改资料</h1>
    <ol class="breadcrumb">
        <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
        <li><a href="#">个人设置</a></li>
        <li class="active">修改资料</li>
    </ol>
{{/block}}
{{block name="content"}}
    <div class="row">
        <div class="col-md-6">
            <form role="form" method="post" action="">
                <div class="form-group">
                    <div class="image">
                        <img id="faceImage" src="{{$face|default:'/static/admin/img/avatar.png'}}" width="120" height="120" class="img-circle" alt="User Image">
                    </div>
                    <br/>
                    <input type="file" id="uploadFace"/>
                    <input name="face" value="{{$data.face}}" type="hidden"/>
                </div>
                <div class="form-group">
                    <label>用户名字</label>
                    <input type="text" name="name" value="{{$data.name}}" class="form-control" placeholder="输入你的名字">
                </div>
                <div class="form-group">
                    <label>电子邮箱</label>
                    <input type="text" class="form-control" value="{{$data.email}}"  name="email" placeholder="请输入电子邮箱">
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
    <link href="/static/third/uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
{{/block}}
{{block name="scripts"}}
    {{include file="../includes/submit_form.tpl"}}
    <script type="text/javascript" src="/static/third/uploadify/jquery.uploadify.min.js"></script>
    <!-- page script -->
    <script type="text/javascript">
    $(function () {
        $('#uploadFace').uploadify({
            swf : '/static/third/uploadify/uploadify.swf',
            buttonText : '更换头像',
            multi: false,
            fileSizeLimit: '6MB',
            removeCompleted: false,
            buttonClass: 'buttonClass',
            uploader: '/upload_file',
            overrideEvents: ['onUploadComplete', ''],
            onUploadComplete: function (file) {
                $('#' + file.id).remove();
            },
            onUploadSuccess: function (file, data, response) {
                var res = $.parseJSON(data);
                if (res.error) {
                    $('#alertModal .modal-body').text(res.message);
                    $("#alertModal").modal('show');
                } else {
                    $('[name=face]').val(res.url);
                    $('#faceImage').attr('src', res.url);
                }
            }
        });
    });
    </script>
{{/block}}