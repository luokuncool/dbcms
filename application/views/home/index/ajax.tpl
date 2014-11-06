{extends file="../public/gird.tpl"}
{block name="search_block"}
    <table id="searchBlock">
        <tr>
            <td>开始日期：</td>
            <td><input class="easyui-datebox" type="text" name="startDate" /></td>
            <td width="100" align="right">结束日期：</td>
            <td><input class="easyui-datebox" type="text" name="endDate" /></td>
            <td>&nbsp;&nbsp;<a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">检索</a></td>
            <td>{widget path='widget/test/dd'}</td>
        </tr>
    </table>
{/block}
{block name="row_list"}
    <tr>
        <th data-options="field:'ck',checkbox:true"></th>
        <th data-options="field:'itemid',sortable:true">Item ID</th>
        <th data-options="field:'productid'">Product</th>
        <th data-options="field:'listprice',align:'right'">List Price</th>
        <th data-options="field:'unitcost',align:'right'">Unit Cost</th>
        <th data-options="field:'attr1'">Attribute</th>
        <th data-options="field:'status',align:'center'">Status</th>
    </tr>
{/block}
{block name="script"}
    <script type="text/javascript">
    $(function(){
        var searchButton = $('#searchButton'),
            searchBlock  = $('#searchBlock'),
            dataGrid     = $('#dataGrid'),
            queryParams  = dataGrid.datagrid('options').queryParams,
            searchFun    = function(){
                $(searchBlock).find('[name]').each(function(){
                    if($(this).val() !== '') queryParams[$(this).attr('name')] = $(this).val();
                    dataGrid.datagrid('reload');
                });
            };
        searchButton.click(searchFun);
    });
    </script>
{/block}