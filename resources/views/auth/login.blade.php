@extends('layouts.app')

@section('content')


    <div layout="column" layout-align="center center" class="layoutSingleColumn_compact">

        <md-content class="md-padding">

            <img src="/icons/qanya.gif" width="100px">

            <div layout="row" layout-padding="">

                <div flex>

                    <form role="form" method="POST" action="{{ url('/login') }}" layout="column">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <md-input-container md-no-float class="md-block">
                                <input type="email" name="email" value="{{ old('email') }}"
                                       placeholder="@{{ 'KEY_EMAIL' | translate }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </md-input-container>
                        </div>



                        <md-input-container md-no-float class="md-block">
                            <input type="password" name="password"
                                   placeholder="@{{ 'KEY_PASSWORD' | translate }}">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </md-input-container>


                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" checked>
                                @{{ 'KEY_REMEMBER_ME' | translate }}
                            </label>
                        </div>

                        <span flex></span>

                        <md-button
                                layout="column" layout-align="center"
                                aria-label="@{{ 'KEY_LOGIN'  | translate }}"
                                type="submit" class="md-primary md-raised md-block">
                                @{{ 'KEY_LOGIN'  | translate }}
                        </md-button>

                    </form>


                    <md-button
                            layout="column" layout-align="center"
                            class="md-hue-1" aria-label="Join us" ng-href="{{ url('/auth/facebook') }}">
                            @{{ 'KEY_LOGIN_FB' | translate }}
                    </md-button>


                    <span flex></span>

                    <md-button
                            layout="column" layout-align="center"
                            class="md-accent" aria-label="Join us" ng-href="{{ url('/register') }}">
                        @{{ 'KEY_CREATE_ACCT' | translate }}
                    </md-button>

                    <md-button
                            layout="column" layout-align="center"
                            href="{{ url('/password/reset') }}">
                        @{{ 'KEY_FORGOT_PWD' | translate }}
                    </md-button>

                </div>

                <div flex hide-xs="">
                    <img src="/icons/chicago.jpg" class="img-fluid">
                </div>

            </div>
        </md-content>
    </div>


@endsection
