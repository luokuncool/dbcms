{extends file="../public/layout.tpl"}
{block name="body"}
    <table class="easyui-datagrid"
           data-options="fitColumns:true,fit:true,muliteSelect:true,border:false,collapsible:true,rownumbers:false,singleSelect:false,url:'/home/get_json',method:'get',pagination:true" width="100%">
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