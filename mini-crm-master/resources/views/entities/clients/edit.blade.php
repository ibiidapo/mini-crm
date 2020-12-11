@extends('layouts.app')

@section('content')
  <div class="container mx-auto text-center">
    <client-form :client="{{$client}}"></client-form>
  </div>
@stop
