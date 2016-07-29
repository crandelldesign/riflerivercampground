<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <li class="{{(isset($active_page)) && ($active_page == 'home')?'active':''}}"><a href="{{url('/admin')}}">Home</a></li>
            <li class="{{(isset($active_page)) && ($active_page == 'reservations')?'active':''}}"><a href="{{url('/admin/reservations')}}">Check Reservations</a></li>
            <li class="{{(isset($active_page)) && ($active_page == 'add-reservation')?'active':''}}"><a href="{{url('/admin/reservations/add')}}">Add New Reservation</a></li>
            <li class="header"></li>
            <li class="{{(isset($active_page)) && ($active_page == 'camping')?'active':''}}"><a href="{{url('/admin/camping')}}">Edit Camp Sites</a></li>
            <li class="{{(isset($active_page)) && ($active_page == 'cabins')?'active':''}}"><a href="{{url('/admin/cabins')}}">Edit Cabin Sites</a></li>
            <li class="{{(isset($active_page)) && ($active_page == 'holidays')?'active':''}}"><a href="{{url('/admin/holidays')}}">Edit Holidays</a></li>
            <!--<li class="treeview {{(isset($active_page)) && ($active_page == 'products')?'active':''}}">
                <a href="#"><span>Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/')}}/admin/products">Edit Product Categories</a></li>
                </ul>
            </li>-->
            <li class="header"></li>
            <li><a href="{{url('/')}}">Back to Rifle River Campground Website</a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>