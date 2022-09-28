<nav class="header__menu mobile-menu">
    <ul>
        <li class="active"><a href="{{ route('index') }}">Trang chủ</a></li>
        @if (!empty($menus))
            <li><a href="{{ route('shop') }}">Shop</a>
                <ul class="dropdown">
                    @foreach ($menus as $each)
                        @if ($each->slug !== PROMOTION)
                            <li><a href="{{ route('menu', $each->slug) }}"> {{ $each->name }} </a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @foreach ($menus as $each)
                @if ($each->slug == PROMOTION)
                    <li><a href="{{ route('menu', $each->slug) }}"> {{ $each->name }} </a></li>
                @endif
            @endforeach
        @endif
        <li><a href="{{ route('blogs') }}">Blogs</a></li>
        <li><a href="{{ route('contact') }}">Contacts</a></li>
    </ul>
</nav>
