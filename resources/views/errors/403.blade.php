@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
{{-- @section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
@section('message')
{{ __($exception->getMessage() ?: 'Forbidden') }}
<br>
<a href="{{ url('/login') }}" style="text-align: center !important">Back to Login</a>
@endsection
