@extends('layouts.admin')
@section('content-header')
    <h1>Camp Sites</h1>
@stop
@section('content')
<div class="row">
    <div class="col-lg-10">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    <li>{{session('success')}}</li>
                </ul>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        
        <div class="box">
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Site #</th>
                            <th>Type</th>
                            <th>Adult Price</th>
                            <th>Child Price</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{url('/admin/camping')}}" class="form-horizontal">
                        <tr>
                            <td><input name="site_id" class="form-control" value="{{old('site_id')}}"></td>
                            <td>
                                <select name="type" class="form-control site-type">
                                    <option value="rustic" {{old('type') == 'rustic'?'selected':''}}>Rustic</option>
                                    <option value="modern" {{old('type') == 'modern'?'selected':''}}>Modern</option>
                                </select>
                            </td>
                            <td><input name="adult_price" class="form-control adult-price" value="{{old('adult_price')?number_format(old('adult_price'),2):'15.00'}}" placeholder="0.00"></td>
                            <td><input name="child_price" class="form-control child-price" value="{{old('adult_price')?number_format(old('child_price'),2):'3.00'}}" placeholder="0.00"></td>
                            <td>
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <button type="submit" class="btn btn-success">Add</button>
                            </td>
                        </tr>
                        </form>
                        @foreach ($campsites as $campsite)
                        <form method="post" action="{{url('/admin/camping')}}" class="form-horizontal">
                        <tr>
                            <td><input name="site_id" class="form-control" value="{{$campsite->site_id}}"></td>
                            <td>
                                <select name="type" class="form-control">
                                    <option value="rustic" {{$campsite->type == 'rustic'?'selected':''}}>Rustic</option>
                                    <option value="modern" {{$campsite->type == 'modern'?'selected':''}}>Modern</option>
                                </select>
                            </td>
                            <td><input name="adult_price" class="form-control adult-price" value="{{number_format($campsite->adult_price,2)}}" placeholder="0.00"></td>
                            <td><input name="child_price" class="form-control child-price" value="{{number_format($campsite->child_price,2)}}" placeholder="0.00"></td>
                            <td>
                                <input type="hidden" name="campsite_id" value="{{$campsite->id}}">
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <button type="submit" class="btn btn-success">Update</button>
                            </td>
                        </tr>
                        </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function()
    {
        $('.site-type').on('change', function(event)
        {
            var row = $(this).parents('tr');
            if ($(this).val() == 'rustic') {
                row.find('.adult-price').val('15.00');
            } else {
                row.find('.adult-price').val('18.00');
            }
        });
    });
</script>
@stop