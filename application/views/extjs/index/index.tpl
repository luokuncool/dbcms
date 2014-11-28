{extends file="../public/layout.tpl"}
{block name="head"}
    <script type="text/javascript">
    Ext.onReady(function(){
        var Main = Ext.create('Ext.panel.Panel', {
            width:'100%',
            height:window.innerHeight,
            layout: 'border',
            items: [{
                region: 'north',     // position for region
                xtype: 'panel',
                height: 100
            },{
                // xtype: 'panel' implied by default
                title: '主菜单栏',
                region:'west',
                xtype: 'panel',
                width: 200,
                collapsible: true,   // make collapsible
                split: true,         // enable resizing
                layout: 'fit'
            },{
                region: 'center',     // center region is required, no width/height specified
                xtype: 'panel',
                id: 'main',
                items:Ext.create('Ext.tab.Panel', {
                    width: 300,
                    height: 200,
                    activeTab: 0,
                    bodyPadding: 5,
                    items: [
                        {
                            title: 'Tab 1',
                            html : 'A simple tab'
                        },
                        {
                            title: 'Tab 2',
                            closable:true,
                            html : 'Another one'
                        }
                    ]
                }),
                layout: 'fit'
            }],
            renderTo: Ext.getBody()
        });
        Ext.get(window).on('resize', function(){
            Main.setHeight(window.innerHeight);
        });
    });
    </script>
{/block}