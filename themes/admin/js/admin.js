(function($){
  $.fn.ajaxSubmit = function(options){
    options = $.extend({
      waitMessage:'请稍候..'
    }, options);
    return this.each(function(){
      var form = $(this)
        , action = form.attr('action') || location.href
        , submitValue = form.find('input[type=submit]').val();

      if (this.nodeName != 'FORM') return;
      form.bind('submit', function(e){
        form.find('input[type="submit"],[type="image"]').val(options.waitMessage).attr('disabled', 'disabled').css('opacity', 0.6);
        typeof options.beforeSend == 'function' && options.beforeSend();
        $.post(action, form.serializeArray(), function(res){
          if (res.success) {
            if (typeof options.successCallback == 'function') options.successCallback(res);
          } else {
            if (typeof options.errorCallback == 'function') options.errorCallback(res);
          }
          form.find('input[type="submit"],[type="image"]').val(submitValue).removeAttr('disabled').css('opacity', 1);
        }, 'json');
        return false;
      });
    });
  }
})(jQuery);

$(function(){
  var hyMainC = $('#hyMainC');

  hyMainC.jScrollPane({
    showArrows : false,
    autoReinitialise : true,
    mouseWheelSpeed : 100,
    autoReinitialiseDelay : 100,
    keepScrollWidth : 12
  }).data('jsp');

  var ajaxGet = $('.ajaxGet');
  ajaxGet.click(function(){
    var self = this
      , url = $(self).attr('href')
      , thisFunc = arguments.callee;
    $(self).unbind('click', thisFunc);
    layer.load('请稍等...');
    $.get(url, function(res){
      if (res.success) {
        layer.msg(res.message, 1, 1, function(){
          location.reload(true);
        });
      } else {
        layer.msg(res.message, 1, 3, function(){
          location.reload(true);
        });
      }
      $(self).bind('click', thisFunc);
    }, 'json');
    return false;
  });
  //表单美化
  $('input').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue',
    increaseArea: '40%' // optional
  });
  $('select').select2();

  //顶部菜单
  var topMenuBox = $('.topMenuBox')
    , hyTopMenuMore = topMenuBox.find('#hyTopMenuMore')
    , drop = topMenuBox.find('.drop')
    , deleteMenu = topMenuBox.find('.iconBg')
    , dropMenu = topMenuBox.find('.dropMenu');
  topMenuBox.find('.item').mouseenter(function(){
    $(this).addClass('hover');
  }).mouseleave(function(){
    $(this).removeClass('hover');
  });
  $('#hyTopMenuMore').jScrollPane({
    showArrows : false,
    autoReinitialise : true,
    mouseWheelSpeed : 100,
    autoReinitialiseDelay : 100
  }).data('jsp');
  drop.mouseenter(function(){
    dropMenu.css('visibility', 'visible');
  }).mouseleave(function(){
    dropMenu.css('visibility', 'hidden')
  });
  deleteMenu.mouseenter(function(){
    $(this).removeClass('iconBox03').addClass('iconBox04');
  }).mouseleave(function(){
    $(this).removeClass('iconBox04').addClass('iconBox03');
  });
  //侧栏菜单
  var hyNavTree = $('#hyNavTree')
    , addMenu = hyNavTree.find('.treeIcon .iconBg');
  hyNavTree.find('.nTB_twoP').mouseenter(function(){
    $(this).addClass('selected');
  }).mouseleave(function(){
    $(this).removeClass('selected');
  });
  hyNavTree.jScrollPane({
    showArrows : false,
    autoReinitialise : true,
    mouseWheelSpeed : 100,
    autoReinitialiseDelay : 100
  }).data('jsp');
  addMenu.mouseenter(function(){
    $(this).addClass('iconBox14').removeClass('iconBox13');
  }).mouseleave(function(){
    $(this).removeClass('iconBox14').addClass('iconBox13');
  });
});
//KindEditor相关调用
KindEditor.ready(function(K) {
  //编辑器
  var editor = K.editor({
    allowFileManager : true
  });;
  K.create('[editor_field]', {
    items : [
      'source', '|', 'undo', 'redo', '|', 'cut', 'copy', 'paste',
      'plainpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
      'clearhtml', 'selectall', '|', 'baidumap', 'link', 'unlink', 'about', '/',
      'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', '|', 'bold',
      'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image', 'insertfile', 'table', 'hr'
    ],
    afterCreate : function() {
      var self = this;
      K.ctrl(this.edit.iframe.get(0).contentWindow.document, 13, function() {
        self.sync();
        $('#enterResponse').trigger('click');
      });
    },
    afterBlur : function() {
      this.sync();
    },
    minWidth : 650,
    minHeight : 200,
    allowImageRemote : true,
    allowFileManager : true
  });

  //图片上传
  K('[upload_pic]').click(function() {
    var inputName = $(this).attr('upload_pic');
    editor.loadPlugin('image', function() {
      editor.plugin.imageDialog({
        showRemote : true,
        imageUrl : K('[name='+inputName+']').val(),
        clickFn : function(url, title, width, height, border, align) {
          K('[name='+inputName+']').val(url);
          editor.hideDialog();
        }
      });
    });
  });
});