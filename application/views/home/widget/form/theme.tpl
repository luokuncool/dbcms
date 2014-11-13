{extends file="../base_widget.tpl"}
{block name="body"}
    <form id="postForm" action="{$baseUrl}setting/theme" method="post">
        <div class="easyui-panel" title="{$widgetName}" data-options="collapsible:true,fit:true" style="padding: 5px;">
            <div class="easyui-panel" data-options="reigin:'center', collapsible:true, border: false" style="padding:10px;">
                <table>
                    <tr>
                        <td align="right">主题：</td>
                        <td>
                            <select class="easyui-combobox" name="myTheme"  data-options="editable:true,width:200,height:24">
                                {foreach $themeList as $theme}
                                    <option value="{$theme}" {if $theme eq $myTheme}selected{/if}>{$theme}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="&nbsp;"></td>
                        <td>
                            <a class="easyui-linkbutton" id="submitForm" data-options="iconCls:'icon-save'" href="javascript:;" style="padding:0 5px; border-radius: 2px 2px 2px;">提交主题</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
{/block}
{block name="script"}
	<script type="text/javascript" src="{$basePath}/public/home/js/public.js"></script>
    <script type="text/javascript">
    $(function(){
        var submitForm = $('#submitForm'),
            postForm   = $('#postForm');
        submitForm.click(function(){
            postForm.form('submit', {
                onSubmit : App.submitBefore,
                success : App.successHandler
            });
        });
    });
    </script>
{/block}