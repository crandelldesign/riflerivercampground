@extends('master.templates.master')

@section('head')
<script src='https://www.google.com/recaptcha/api.js'></script>
@stop

@section('body')

<h1>Contact Us</h1>

<address>Rifle River Campground &amp; Canoe Livery<br>
    5825 Townline Rd<br>
    PO Box 105<br>
    Sterling, MI 48659</address>

<p>Phone: <a href="tel:989-654-2556" target="_blank">989-654-2556</a><br>
    Fax: <a href="tel:9896542521" target="_blank">989-654-2521</a><br>
    Email: <a href="mailto:reservations@riflerivercampground.com" target="_blank">reservations@<wbr>riflerivercampground.com</a></p>
<p><a href="https://www.facebook.com/RifleRiverCampground" target="_blank"><i class="fa fa-facebook-square"></i> Find us on Facebook</a></p>

<div class="row">
    <div class="col-sm-6">
        <form action="{{url('/contact')}}" method="post" class="wpcf7-form">
                <div class="control-group form-group">
                    <label>Name:</label><br>
                    <input type="text" name="name" value="{{old('name')}}" size="40" class="form-control" aria-required="true" aria-invalid="false" placeholder="Name">
                </div>
<div class="control-group form-group">
   <label>Email Address:</label><br>
   <span class="wpcf7-form-control-wrap email-948"><input type="email" name="email-948" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" aria-required="true" aria-invalid="false"></span>
</div>
<div class="control-group form-group">
   <label>Phone Number:</label><br>
   <span class="wpcf7-form-control-wrap tel-368"><input type="tel" name="tel-368" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel form-control" aria-required="true" aria-invalid="false"></span>
</div>
<div class="control-group form-group">
   <label>Best Time to Call:</label><br>
   <span class="wpcf7-form-control-wrap text-294"><input type="text" name="text-294" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false"></span>
</div>
<div class="control-group form-group">
   <label>Message:</label><br>
   <span class="wpcf7-form-control-wrap textarea-402"><textarea name="textarea-402" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false"></textarea></span>
</div>
<div class="control-group form-group">
    <div class="g-recaptcha" data-sitekey="6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3"></div>
</div>
<div class="control-group form-group">
    {!! csrf_field() !!}
    <button type="submit" value="Send" class="btn btn-blue">Submit</button>
</div>
<div class="wpcf7-response-output wpcf7-display-none"></div>

</form>

</div>
<div class="col-sm-6">
<div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d91711.00029593651!2d-84.026555!3d44.083999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x53d4159da39a1078!2sRifle+River+Campground+%26+Canoe+Livery!5e0!3m2!1sen!2sus!4v1441941313578" width="600" height="450" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
</div>
</div>

@stop