{extends file="../public/form.tpl"}
{block name="form"}
    {foreach $modelList as $model}
    <tr>
        <td align="right" valign="top"><font color="red">*</font> 操作代码：</td>
        <td valign="top"><input class="easyui-textbox" type="text" name="code" value="{$data.code}" data-options="width:200, required:false"></td>
    </tr>
    {/foreach}
{/block}