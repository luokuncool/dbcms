{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north'" style="height:{$searchBlockHeight}px; overflow:hidden; padding:5px;border-left: none; border-right: none; border-top:none;">
        {block name="search_block"}{/block}
    </div>
    <div data-options="region:'center',border:false">
        <table id="dataGrid" class="easyui-datagrid"
               data-options="{if $editable}onClickRow:{$editHandler},{/if}fitColumns:true,fit:true,muliteSelect:true,border:false,collapsible:true,rownumbers:false,singleSelect:false,url:'{$data_grid_url}',method:'get',pagination:true,pageSize:25,pageList:[15,20,25,30,50]" width="100%">
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
        var searchButton = $('#searchButton'),
            searchBlock  = $('#searchBlock'),
            dataGrid     = $('#dataGrid'),
            queryParams  = dataGrid.datagrid('options').queryParams,
            searchFun    = function(){
                $(searchBlock).find('[name]').each(function(){
                    console.log(this);
                    if($(this).val() !== '') {
                        queryParams[$(this).attr('name')] = $(this).val();
                    } else {
                        delete queryParams[$(this).attr('name')];
                    }
                });
                dataGrid.datagrid('reload');
            };
        searchButton.click(searchFun);
    });
    </script>
    {block name="script"}{/block}
{/block}