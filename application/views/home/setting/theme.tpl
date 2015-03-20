{{extends file="../public/form.tpl"}}
{{block name="form"}}
    <tr>
        <td align="right">选择主题：</td>
        <td>
            <select class="easyui-combobox" name="myTheme" data-options="editable:false,width:200,height:24">
                {{foreach $themeList as $theme}}
                    <option value="{{$theme}}" {{if $theme eq $myTheme}}selected{{/if}}>{{$theme}}</option>
                {{/foreach}}
            </select>
        </td>
    </tr>
{{/block}}