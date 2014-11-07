{extends file="../public/form.tpl"}
{block name="form"}
    <tr>
        <td align="right">选择主题：</td>
        <td>
            <select class="easyui-combobox" name="my_theme"  data-options="editable:true,width:150">
                {foreach $theme_list as $theme}
                    <option value="{$theme}" {if $theme eq $my_theme}selected{/if}>{$theme}</option>
                {/foreach}
            </select>
        </td>
    </tr>
{/block}