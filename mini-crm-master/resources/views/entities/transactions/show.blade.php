@extends('layouts.app')

@section('content')
  <div class="container mx-auto text-center">
    <transactions-edit :transaction="{{$transaction}}" disabled></transactions-edit>
  </div>
@stop