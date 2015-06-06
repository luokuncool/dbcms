<input type="file" name="file_upload" id="{{$fileName}}" style="display: none;;"/>
<div id="{{$fileName}}-result"></div>
<script type="text/javascript">
$(function () {
    var resultId = '#{{$fileName}}-result';
    $("#{{$fileName}}").uploadify({
        width: 70,
        height: 18,
        uploadLimit : {{$uploadLimit|default:1}},
        removeCompleted: false,
        'buttonText': '选择',
        'swf': '/static/third/uploadify/uploadify.swf',
        'uploader': '/upload_file',
        overrideEvents : ['onUploadComplete', 'onSelect'],
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
        },
        onSelectError : function (file, errorCode, errorMsg) {

        }
    });
});
</script>
