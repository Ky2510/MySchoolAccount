@extends('layouts.appbackend')

@section('content')
<div class="card-title font-weight-medium">{{ __('Dashboard') }} </div>
<p class="text-muted"> 
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    {{ __('You are logged in!') }}
</p>
@endsection
