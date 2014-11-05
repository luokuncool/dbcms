{extends file="../public/layout.tpl"}
{block name="body"}
    <table id="dg" class="easyui-datagrid" title="CheckBox Selection on DataGrid" style="width:100%; height: 100%;"
           data-options="rownumbers:true,singleSelect:true,url:'/home/get_json',method:'get'">
        <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'itemid'">Item ID</th>
            <th data-options="field:'productid'">Product</th>
            <th data-options="field:'listprice',align:'right'">List Price</th>
            <th data-options="field:'unitcost',align:'right'">Unit Cost</th>
            <th data-options="field:'attr1'">Attribute</th>
            <th data-options="field:'status',align:'center'">Status</th>
        </tr>
        </thead>
    </table>
{/block}
{block name="head"}

{/block}