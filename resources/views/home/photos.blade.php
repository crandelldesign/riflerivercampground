@extends('master.templates.master')

@section('body')

<h1>Photos</h1>

<p>Rifle River Campground is a beautiful place to visit. Check out the images to see for yourself.</p>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" data-caption="Our youngest guests enjoy hours of fun on our Rainbow Play System." href="{{url('/img/photos/playground2.jpg')}}"><img class="img-responsive" alt="Our youngest guests enjoy hours of fun on our Rainbow Play System." src="{{url('/img/photos/playground2-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" data-caption="Peaceful scenes abound on our hiking trail." href="{{url('/img/photos/hiking2.jpg')}}"><img class="img-responsive" alt="Peaceful scenes abound on our hiking trail." src="{{url('/img/photos/hiking2-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/hiking1.jpg')}}"><img class="img-responsive" alt="Hiking" src="{{url('/img/photos/hiking1-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/fawn.jpg')}}"><img class="img-responsive" alt="Fawn" src="{{url('/img/photos/fawn-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/eagle2.jpg')}}"><img class="img-responsive" alt="Eagle" src="{{url('/img/photos/eagle2-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo1.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 1" src="{{url('/img/photos/photo1-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo2.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 2" src="{{url('/img/photos/photo2-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo3.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 3" src="{{url('/img/photos/photo3-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo4.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 4" src="{{url('/img/photos/photo4-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo5.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 5" src="{{url('/img/photos/photo5-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo6.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 6" src="{{url('/img/photos/photo6-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo7.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 7" src="{{url('/img/photos/photo7-small.jpg')}}"></a>
    </div>
    <div class="col-sm-6 col-md-3">
        <a class="img-modal" href="{{url('/img/photos/photo8.jpg')}}"><img class="img-responsive" alt="Photo of Rifle River Campground 8" src="{{url('/img/photos/photo8-small.jpg')}}"></a>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="img-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script id="img-modal-template" type="x-tmpl-mustache">
    @{{#if caption}}
    <p class="caption">@{{caption}}</p>
    @{{/if}}
    <div class="image"><img src="@{{src}}" alt="@{{caption}}" class="img-responsive"></div>
</script>

@stop

@section('scripts')

<script>
    $(document).ready(function()
    {
        $('.img-modal').on('click', function(event)
        {
            event.preventDefault();
            var src = $(this).attr('href');
            var caption = $(this).data('caption');
            var source = $("#img-modal-template").html();
            var template = Handlebars.compile(source);
            var html = template({
                src: src,
                caption: caption
            });
            $('#img-modal .modal-body').html(html);
            $('#img-modal').modal('show');
        });
    });
</script>

@stop
