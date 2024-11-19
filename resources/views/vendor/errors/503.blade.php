@extends(errorsLayout())
@section('title', translate('Service Unavailable'))
@section('code', '503')
@section('message', translate('Sorry, the server is currently unavailable, and we are unable to fulfill your request. Please try again later.'))
