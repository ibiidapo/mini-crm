@extends('layouts.app')

@section('content')
  <div class="container mx-auto text-center">
    <transactions-edit :transaction="{{$transaction}}"></transactions-edit>
  </div>
@stop