{extends file="../public/layout.tpl"}
{block name="body"}
    <form action="" method="post">
        <div class="easyui-panel" title="" data-options="collapsible:true, border: false" style="padding:5px;">
            <table>
                {block name="form"}{/block}
            </table>
        </div>
        <table>
            <tr>
                <td colspan="2" align="center">
                    <a class="easyui-linkbutton" id="searchButton" data-options="" href="javascript:;" style="padding:0 5px; border-radius: 2px 2px 2px;">提交保存</a>
                </td>
            </tr>
        </table>
    </form>
{/block}
{block name="head"}

{/block}