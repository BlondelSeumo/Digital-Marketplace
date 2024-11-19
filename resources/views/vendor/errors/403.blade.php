@extends(errorsLayout())
@section('title', translate('Forbidden'))
@section('code', '403')
@section('message', translate('Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.'))
