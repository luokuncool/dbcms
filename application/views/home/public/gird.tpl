{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north'" style="overflow:hidden; padding:5px;border-left: none; border-right: none; border-top:none;">
        {block name="search_block"}{/block}
    </div>
    <div data-options="region:'center',border:false">
        <table id="dataGrid" class="easyui-datagrid"
               data-options="fitColumns:true,fit:true,muliteSelect:true,border:false,collapsible:true,rownumbers:false,singleSelect:false,url:'{$data_grid_url}',method:'get',pagination:true" width="100%">
            <thead>
            {block name="row_list"}{/block}
            </thead>
        </table>
    </div>
{/block}
{block name="head"}
    <script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $('#datagrid').datagrid('resize');
        });
    });
    </script>
    {block name="script"}{/block}
{/block}