{{extends file="../base_widget.tpl"}}
{{block name="body"}}
    <input type="file" name="file_upload" id="{{$fileName}}" style="display: none;;"/>
    <div id="{{$fileName}}-result"></div>
{{/block}}
{{block name="script"}}
    <link rel="stylesheet" href="{{$baseUrl}}static/third/uploadify/uploadify.css"/>
    <script type="text/javascript" src="{{$baseUrl}}static/third/uploadify/jquery.uploadify.min.js"></script>
    <script type="text/javascript">
    $(function () {
        var resultId = '#{{$fileName}}-result';
        $("#{{$fileName}}").uploadify({
            width: 70,
            height: 18,
            removeCompleted: false,
            'buttonText': '选择文件',
            'swf': '/static/third/uploadify/uploadify.swf',
            'uploader': '/upload_file',
            onUploadComplete: function (file) {
                $('#' + file.id).remove();
            },
            'onUploadSuccess': function (file, data, response) {
                var res = $.parseJSON(data);
                if (res.error) {
                    Public.alert(res.message);
                } else {
                    var html = '' +
                        '<p>' +
                        res.url +
                        '</p>' +
                        '<input type="hidden" name="{{$fileName}}_url[]" value="' + res.url + '" />';
                    $(resultId).append(html);
                }
            }
        });
    });
    </script>
{{/block}}