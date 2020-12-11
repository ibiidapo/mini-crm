@extends('layouts.app')

@section('content')
  <div class="container mx-auto text-center">
    <client-edit :client="{{$client}}" disabled></client-edit>
  </div>
@stop