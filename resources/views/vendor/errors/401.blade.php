@extends(errorsLayout())
@section('title', translate('Unauthorized'))
@section('code', '401')
@section('message', translate('Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.'))
