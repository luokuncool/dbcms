<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/static/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>超级管理员</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- search form -->
        {{*<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>*}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">常规功能</li>
            {{foreach $sideMenu['menuGroupList'] as $menuGroup}}
                <li class="treeview {{if $menuGroup.group.isCurrentGroup === 1}}active{{/if}}">
                    <a href="#">
                        <i class="fa {{$menuGroup.group.iconCls}}"></i> <span>{{$menuGroup.group.groupName}}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        {{foreach $menuGroup['menuList'] as $menu}}
                            <li class="{{if $menu.code == $thisNode}}active{{/if}}"><a href="{{$baseURL}}/{{$menu.code}}"><i class="fa {{$menu.iconCls}}"></i> {{$menu.name}}</a></li>
                        {{/foreach}}
                    </ul>
                </li>
            {{/foreach}}
            <li class="header">开发者专用</li>
            <li><a href="{{$baseURL}}/home/icons"><i class="fa fa-book text-red"></i> <span>图标速查</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>