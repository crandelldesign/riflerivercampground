@extends('layouts.admin')
@section('content-header')
    <h1>Cabin Sites</h1>
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
                            <th>Price<br>
                                <small>(1-4 adults)</small></th>
                            <th>Additional Adult Price</th>
                            <th>Additional Child Price</th>
                            <th>Max Capacity</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{url('/admin/cabins')}}" class="form-horizontal">
                        <tr>
                            <td><input name="site_id" class="form-control" value="{{old('site_id')}}"></td>
                            <td><input name="price" class="form-control initial-price" value="{{old('price')?number_format(old('price'),2):'100.00'}}" placeholder="0.00"></td>
                            <td><input name="additional_adult_price" class="form-control adult-price" value="{{old('additional_adult_price')?number_format(old('additional_adult_price'),2):'25.00'}}" placeholder="0.00"></td>
                            <td><input name="additional_child_price" class="form-control child-price" value="{{old('additional_adult_price')?number_format(old('additional_child_price'),2):'5.00'}}" placeholder="0.00"></td>
                            <td><input name="max_capacity" class="form-control" value="{{old('max_capacity')?old('max_capacity'):'6'}}" placeholder="0.00"></td>
                            <td>
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <button type="submit" class="btn btn-success">Add</button>
                            </td>
                        </tr>
                        </form>
                        @foreach ($cabins as $cabin)
                        <form method="post" action="{{url('/admin/cabins')}}" class="form-horizontal">
                        <tr>
                            <td><input name="site_id" class="form-control" value="{{$cabin->site_id}}"></td>
                            <td><input name="price" class="form-control initial-price" value="{{number_format($cabin->price,2)}}" placeholder="0.00"></td>
                            <td><input name="additional_adult_price" class="form-control adult-price" value="{{number_format($cabin->additional_adult_price,2)}}" placeholder="0.00"></td>
                            <td><input name="additional_child_price" class="form-control child-price" value="{{number_format($cabin->additional_child_price,2)}}" placeholder="0.00"></td>
                            <td><input name="max_capacity" class="form-control" value="{{$cabin->max_capacity}}" placeholder="0.00"></td>
                            <td>
                                <input type="hidden" name="cabin_id" value="{{$cabin->id}}">
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
</script>
@stop