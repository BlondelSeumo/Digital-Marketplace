@extends(errorsLayout())
@section('title', translate('Too Many Requests'))
@section('code', '429')
@section('message', translate('Sorry, you have exceeded the rate limit for accessing this resource. Please wait a few minutes and try again.'))
