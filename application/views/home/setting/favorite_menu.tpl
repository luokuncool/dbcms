{extends file="../public/grid.tpl"}
{block name="searchBlock"}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="100" align="right">菜单名称：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>
            <td>&nbsp;&nbsp;<a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">检索</a></td>
            <td align="right">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="Node.setFavoriteMenu();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">设为常用</a>
            </td>
        </tr>
    </table>
{/block}
{block name="rowList"}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'name',align:'center',sortable:true,editor:'text'" width="10%">菜单名称</th>
        <th formatter="Node.formatCode" data-options="field:'code',align:'left',sortable:true,editor:'text'" width="88%">地址</th>
    </tr>
{/block}
{block name="script"}
    <script type="text/javascript">
    var Node = Object();

    /**
     * 输出超链接
     */
    Node.formatCode = function(field, row) {
        return '<a class="easyui-linkbutton" href="javascript:Public.addTab(\''+row.name+'\', \'{$baseUrl}'+field+'\')" data-options="" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">{$baseUrl}'+field+'</a>';
    };

    /**
     * 提交选中用户
     */
    Node.setFavoriteMenu = function() {
        Public.processing();
        $.post('{$baseUrl}setting/set_favorite_menu', { nodeIds : Public.getIds() }, Public.successHandler, 'text');
    };

    $(function(){
        //设置表格对象
        var gridOptions = Public.getGrid().datagrid('options');
        gridOptions.onLoadSuccess = function(){
            //已有菜单
            var existsMenus = [{$nodeIds}];
            for(var i = 0; i<existsMenus.length; i++) {
                Public.getGrid().datagrid('selectRecord', existsMenus[i]);
            }
        };
    });
	</script>
{/block}