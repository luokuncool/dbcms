{extends file="../public/base.tpl"}
{block name="body"}
    <div data-options="region:'north',height:{$searchBlockHeight|default:"'auto'"}" style="overflow:hidden; padding:5px;border-left: none; border-right: none; border-top:none;">
        {block name="searchBlock"}{/block}
    </div>
    <div data-options="region:'center',border:false">
        <table id="dataGrid" class="easyui-datagrid" data-options="
               {if $editable}onClickRow:{$editHandler},{/if}
               fitColumns:true,
               fit:true,
               muliteSelect:true,
               border:false,
               collapsible:true,
               rownumbers:false,
               singleSelect:false,
               url:'{$dataGridUrl}',
               method:'get',
               pagination:true,
               pageSize:{$pageSetting.pageSize},
               pageList:{$pageSetting.pageList},
               idField:'id'
               " width="100%">
            <thead>
            {block name="rowList"}{/block}
            </thead>
        </table>
    </div>
{/block}
{block name="head"}
    <script type="text/javascript">
    $(function(){
        $(window).resize(Public.resizeGrid);
        var searchButton = $('#searchButton'),
            searchBlock  = $('#searchBlock'),
            dataGrid     = Public.getGrid(),
            queryParams  = dataGrid.datagrid('options').queryParams,
            searchFun    = function(){
                $(searchBlock).find('[name]').each(function(){
                    if($(this).val() !== '') {
                        queryParams[$(this).attr('name')] = $(this).val();
                    } else {
                        delete queryParams[$(this).attr('name')];
                    }
                });
                dataGrid.datagrid('reload');
            };
        searchButton.click(searchFun);
        $(window).keydown(function(e){
            //e.keyCode == 13 && searchFun();
        });
    });
    </script>
    {block name="script"}{/block}
{/block}