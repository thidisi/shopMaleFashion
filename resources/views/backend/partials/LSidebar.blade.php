<div class="left-side-menu">

    <!-- LOGO -->
    <a href="{{ route('admin.dashboards') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('backend/images/logo.png') }}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('backend/images/logo_sm.png') }}" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ route('admin.dashboards') }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('backend/images/logo-dark.png') }}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('backend/images/logo_sm_dark.png') }}" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="left-side-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboards') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    {{-- <span class="badge badge-success float-right">4</span> --}}
                    <span> Dashboards </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link"  style="overflow: hidden;">
                    <i class="uil-copy-alt"></i>
                    <span> Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
                    <li class="side-nav-item">
                        <a href="{{ route('admin.slides') }}">Slides</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('admin.blogs') }}">Blogs</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('admin.abouts') }}">About</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('admin.contacts') }}">Contacts</a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('admin.comments') }}">Comments</a>
                    </li>

                </ul>
            </li>
            <li class="side-nav-item">
                <a class="side-nav-link" href="javascript: void(0);" aria-expanded="false"  style="overflow: hidden;">
                    <i class="uil-store"></i>
                    Ecommerce
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.categories') }}">Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.attributes') }}">Attributes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.productions') }}">Productions</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discounts') }}">Discounts</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discountProducts') }}">Discount Products</a>
                    </li>
                </ul>
            </li>
            <li class="side-nav-item">
                <a class="side-nav-link" href="{{ route('admin.orders') }}"  style="overflow: hidden;">
                    <i class="uil-tag-alt"></i>
                    Orders</a>
            </li>
            <li class="side-nav-item">
                <a class="side-nav-link" href="{{ route('admin.major-categories') }}"  style="overflow: hidden;">
                    <i class="uil-window-maximize"></i>
                    Menu</a>
            </li>
            <li class="side-nav-item">
                <a class="side-nav-link" href="{{ route('admin.customers') }}"  style="overflow: hidden;">
                    <i class="uil-users-alt"></i>
                    <span> Customers </span></a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('admin.users') }}" class="side-nav-link" aria-expanded="false"  style="overflow: hidden;">
                    <i class="uil-user-plus"></i>
                    {{-- <span class="badge badge-success float-right">4</span> --}}
                    <span> Users </span>
                </a>
            </li>
        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
