{{extends file="../public/grid.tpl"}}
{{block name="rowList"}}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'name',sortable:true" width="18%">角色名</th>
        <th formatter="Public.formatStatus" data-options="field:'status',sortable:true" width="20%">状态</th>
        <th data-options="field:'remark',sortable:true" width="40%">描述</th>
        <th formatter='Role.formatOpt' data-options="field:'opt',align:'center'" width="20%">操作</th>
    </tr>
{{/block}}
{{block name="script"}}
    <script type="text/javascript">
    var Role = Object();

    /**
     * 格式化操作栏
     * @param field
     * @param row
     * @returns {{ string }}
     */
    Role.formatOpt = function (field, row) {
        var tools = '';
        tools += '<a href="javascript:Public.addTab(\'编辑角色【' + row.name + '】\', \'{{$baseUrl}}role/edit/' + row.id + '\')">编辑</a>';
        tools += '&nbsp;&nbsp;<a href="javascript:Public.addTab(\'' + row.name + '授权\', \'{{$baseUrl}}role/set_rights/' + row.id + '\')">授权</a>';
        tools += '&nbsp;&nbsp;<a href="javascript:Public.addTab(\'' + row.name + '列表\', \'{{$baseUrl}}role/set_user/' + row.id + '\')">用户</a>';
        return tools;
    };
    </script>
{{/block}}
{{block name="searchBlock"}}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="70" align="right">角色名称：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="name"/></td>
            <td width="60" align="right">状态：</td>
            <td width="210">
                <select class="easyui-combobox" data-options="editable:false,width:200,height:24" name="status">
                    <option value="">请选择</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </td>
            <td>
                <a class="easyui-linkbutton" id="searchButton" data-options="height:24"
                   style="padding-right: 5px; border-radius: 2px 2px 2px"><i class="iconfont icon-sousuo"></i>检索</a>
            </td>
            <td align="right">
                <a class="easyui-linkbutton" onclick="Public.addTab('添加角色', '{{$baseUrl}}role/create')"
                   href="javascript:;"><i class="iconfont icon-jia"></i>添加</a>
                <a class="easyui-linkbutton" onclick="Public.remove('{{$baseUrl}}role/remove')"><i
                        class="iconfont icon-shanchu"></i>删除</a>
                <a class="easyui-linkbutton" onclick="Public.enable('{{$baseUrl}}role/enable');"><i
                        class="iconfont icon-zhengque"></i>启用</a>
                <a class="easyui-linkbutton" onclick="Public.disable('{{$baseUrl}}role/disable')"><i
                        class="iconfont icon-jinzhi1"></i>禁用</a>
            </td>
        </tr>
    </table>
{{/block}}
