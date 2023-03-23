<ul class="toc_ul">
    @foreach($contents as $key => $header)
        <li class="toc_li">
            @if(isset($header['id']))
                <a href="#header-{{$header['id']}}">{{strip_tags($header['header'])}}</a>
            @endif
        </li>
        @if (!empty($header['childs']))
            @include('nikolay-oskin.contents.table', ['contents' => $header['childs']])
        @endif
    @endforeach
</ul>