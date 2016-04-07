@extends('master.templates.master')

@section('body')

<h1>404 Error: Page Not Found</h1>

<p>The page you are looking for ({{Request::url()}}) isn't here. We apologize for this inconvenience.</p>
<p>If you think you are receiving this page in error, please email <a href="mailto:matt@crandelldesign.com">matt@crandelldesign.com</a> about the issue.</p>

@stop