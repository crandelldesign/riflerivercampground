@extends('master.templates.master')

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
        <div role="form" class="wpcf7" id="wpcf7-f224-p2629-o1" dir="ltr">
            <form action="/contact/#wpcf7-f224-p2629-o1" method="post" class="wpcf7-form" novalidate="novalidate">
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
<div class="wpcf7-form-control-wrap">
    <div data-sitekey="6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3" class="wpcf7-form-control g-recaptcha wpcf7-recaptcha">
        <div>
            <div style="width: 304px; height: 78px;">
                <iframe src="https://www.google.com/recaptcha/api2/anchor?k=6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3&amp;co=aHR0cDovL3d3dy5yaWZsZXJpdmVyY2FtcGdyb3VuZC5jb206ODA.&amp;hl=en&amp;v=r20160404124926&amp;size=normal&amp;cb=mbwf16ytq0o" title="recaptcha widget" width="304" height="78" role="presentation" frameborder="0" scrolling="no" name="undefined"></iframe>
            </div>
            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;  display: none; "></textarea>
        </div>
    </div>
    <noscript>
        <div style="width: 302px; height: 422px;">
            <div style="width: 302px; height: 422px; position: relative;">
                <div style="width: 302px; height: 422px; position: absolute;">
                    <iframe src="https://www.google.com/recaptcha/api/fallback?k=6Le-iwwTAAAAAISVouN7lSSZJ6f_r2hL6rwDG0w3" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none;">
                    </iframe>
                </div>
                <div style="width: 300px; height: 60px; border-style: none; bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
                    <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;">
                    </textarea>
                </div>
            </div>
        </div>
    </noscript>
</div>
</div>
<div class="control-group form-group">
<input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit btn btn-default"><img class="ajax-loader" src="http://www.riflerivercampground.com/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden;">
</div>
<div class="wpcf7-response-output wpcf7-display-none"></div></form></div></div>
<div class="col-sm-6">
<div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d91711.00029593651!2d-84.026555!3d44.083999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x53d4159da39a1078!2sRifle+River+Campground+%26+Canoe+Livery!5e0!3m2!1sen!2sus!4v1441941313578" width="600" height="450" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>
</div>
</div>

@stop