@extends('layouts.app')

@section('content')
    <div layout="row" layout-align="center" class="layoutSingleColumn_compact md-padding" ng-controller="QuestionCtrl as questionCtrl">

        <md-list>

            {{ $topics }}

        </md-list>
    </div>
@endsection