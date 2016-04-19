<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{url('/')}}"><img class="logo" src="{{url('/')}}/img/logo.png" alt="Rifle River Campground"></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-nav">
                    <div class="pull-left">Menu</div>
                    <div class="pull-right">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="top-nav">
                <ul class="nav navbar-nav">
                    <li class="{{(isset($active_page)) && $active_page=='home'?'active':''}}"><a title="Home" href="{{url('/')}}">Home</a></li>
                    <li class="{{(isset($active_page)) && $active_page=='camping'?'active':''}}"><a title="Camping" href="{{url('/camping')}}">Camping</a></li>
                    <li class="{{(isset($active_page)) && $active_page=='cabins'?'active':''}}"><a title="Cabins" href="{{url('/')}}/cabins">Cabins</a></li>
                    <li class="{{(isset($active_page)) && $active_page=='river-trips'?'active':''}} dropdown"><a title="River Trips" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">River Trips <span class="caret"></span></a>
                        <ul role="menu" class=" dropdown-menu">
                            <li><a title="Canoeing" href="{{url('/')}}/river-trips/canoeing/">Canoeing</a></li>
                            <li><a title="Kayaking" href="{{url('/')}}/river-trips/kayaking/">Kayaking</a></li>
                            <li><a title="Tubing" href="{{url('/')}}/river-trips/tubing/">Tubing</a></li>
                            <li><a title="Specials" href="{{url('/')}}/river-trips/specials/">Specials</a></li>
                        </ul>
                    </li>
                    <li class="{{(isset($active_page)) && $active_page=='park-map'?'active':''}}"><a title="Park Map" href="{{url('/')}}/park-map">Park Map</a></li>
                    <li class="{{(isset($active_page)) && $active_page=='photos'?'active':''}}"><a title="Photos" href="{{url('/')}}/photos">Photos</a></li>
                    <li class="{{(isset($active_page)) && $active_page=='contact'?'active':''}}"><a title="Contact" href="{{url('/contact')}}">Contact</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>