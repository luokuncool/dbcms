{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'center',fit:true">
        <div class="easyui-window" title="{$systemName}" data-options="closable:false,maximizable:false,collapsible:false,minimizable:false,draggable:false,resizable:false,width:430,height:260" style="padding:16px 31px;">
            <form id="loginForm" method="post">
                <table>
                    <tr>
                        <td style="position: relative; z-index: 1;">
                            <input class="easyui-textbox iconfont"  type="text" name="uName" data-options="width:350, height:36" style="padding-left: 30px;" />
                            <i class="iconfont icon-yonghu" style="position: absolute; left: 4px; top:16px; font-size: 22px; z-index: 20"></i>
                        </td>
                    </tr>
                    <tr>
                        <td style="position: relative; z-index: 1;">
                            <input class="easyui-textbox" type="password" name="password" data-options="width:350, height:36" style="padding-left: 30px;" />
                            <i class="iconfont icon-suoding" style="position: absolute; left: 4px; top:16px; font-size: 22px; z-index: 20"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a class="easyui-linkbutton" id="submitForm"  href="javascript:;" style="padding:8px 15px"><span style="font-size: 22px"><i class="iconfont icon-zhengque"></i> 登陆</span></a>
                            &nbsp;&nbsp;
                            <a class="easyui-linkbutton" onclick="location.reload();" href="javascript:;" style="padding:8px 15px"><span style="font-size: 22px"><i class="iconfont icon-chexiao"></i> 重填</span> </a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

{/block}
{block name="head"}
    <script type="text/javascript" src="{$basePath}/public/home/js/main.js"></script>
    <script type="text/javascript">
    $(function(){
        var submitForm = $('#submitForm');
        submitForm.click(function(){
            Main.processing();
            $.post('{$baseUrl}login', $('#loginForm').serializeArray(), function(res){
                Main.processed();
                if (res.success) {
                    Main.showMessage(res.message);
                    setTimeout(function(){
                        location.reload(true);
                    }, 1500);
                } else {
                    Main.alert(res.message);
                }
            }, 'json');
        });
    });
    </script>
    <style type="text/css">
        table td { padding: 10px 0px; }
    </style>
{/block}
