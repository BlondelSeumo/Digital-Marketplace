@extends(errorsLayout())
@section('title', translate('Server Error'))
@section('code', '500')
@section('message', translate('Sorry, there was an internal server error, and we were unable to fulfill your request. Please try again later.'))
