<div class="row">
    <div class="col-sm-5">
        <div class="dataTables_info" role="status" aria-live="polite">显示{{$page}}/{{$totalPage}}页, 共{{$total}}条记录 </div>
    </div>
    <div class="col-sm-7">
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <li class="paginate_button {{if $totalPage==0}}disabled{{/if}}"><a href="{{$pageURL}}1">首页</a></li>
                {{if $page <= 1}}
                    <li class="paginate_button previous disabled"><a href="#">上一页</a></li>
                {{else}}
                    <li class="paginate_button previous"><a href="{{$pageURL}}{{$page-1}}">上一页</a></li>
                {{/if}}
                {{foreach $pages as $p}}
                    {{if $page <= 3 && $p<=5}}
                        <li class="paginate_button {{if $p==$page}}active{{/if}}"><a href="{{$pageURL}}{{$p}}">{{$p}}</a></li>
                    {{elseif $totalPage - $page <= 3 && $p>$totalPage - 5}}
                        <li class="paginate_button {{if $p==$page}}active{{/if}}"><a href="{{$pageURL}}{{$p}}">{{$p}}</a></li>
                    {{elseif $page > 3 && $totalPage - $page > 3 &&  $p > $page -3 && $p < $page+3}}
                        <li class="paginate_button {{if $p==$page}}active{{/if}}"><a href="{{$pageURL}}{{$p}}">{{$p}}</a></li>
                    {{/if}}
                {{/foreach}}
                {{if $page >= $totalPage}}
                    <li class="paginate_button next disabled"><a href="#">下一页</a></li>
                {{else}}
                    <li class="paginate_button next"><a href="{{$pageURL}}{{$page+1}}">下一页</a></li>
                {{/if}}
                <li class="paginate_button {{if $totalPage==0}}disabled{{/if}}"><a href="{{$pageURL}}{{$totalPage}}">尾页</a></li>
            </ul>
        </div>
    </div>
</div>