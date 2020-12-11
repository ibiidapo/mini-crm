@extends('layouts.app')

@section('content')
  <div class="container align-content-center  justify-content-center h-100">
    <b-jumbotron bg-variant="secondary" text-variant="white" border-variant="dark" class="mt-5">
      <template slot="header">
        MINI CRM DEMO
      </template>
      <template slot="lead">
        This is a simple demo for testing/demonstrating VueJS and Bootstrap v4 (bootstrap-vue) on new Laravel PHP Framework.
      </template>
      <hr class="my-4">
      <p>
        It uses Bootstrap v4 (bootstrap-vue) and VueJS v2.<br/>
        For Backend it uses Laravel PHP Framework v5.7 and MYSQL 5.7 for database.<br/>
        I have implemented and some unit and feature tests.<br/>
        If you have any questions contact me below or open readme file.<br/>
      </p>
      <b-button href="https://linkedin.com/in/darkpain" variant="dark">LinkedIn</b-button>
    </b-jumbotron>
  </div>
@stop