{extends file="../public/layout.tpl"}
{block name="body"}

{/block}
{block name="head"}
    <script type="text/javascript">
    Ext.onReady(function(){
        Ext.MessageBox.alert('提示', '提交失败！');
    });
    </script>
{/block}