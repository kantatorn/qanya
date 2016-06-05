@extends('layouts.app')

@section('content')


    <div layout="row" layout-align="center" class="layoutSingleColumn" >
        <div flex="100" flex-gt-xs="60">
            <md-tabs md-dynamic-height md-border-bottom>

                {{-- If user login show customize feed--}}
                @if(Auth::user())

                <md-tab label="For you">
                    <md-content>
                        if user login - showe customized feed
                    </md-content>
                </md-tab>

                @endif


                <md-tab label="@{{ 'KEY_MSTVIEW_TDAY' | translate }}">
                    <md-content>

                        @foreach($topics as $topic)

                            <md-card flex>

                                <md-card-title>
                                    <md-card-title-text>
                                        <span class="md-title" layout="row">
                                            <a href="/question/{{$topic->uuid}}">
                                                {{ strip_tags($topic->topic) }}
                                            </a>
                                            <span flex=""></span>
                                            <md-menu>
                                                <md-button class="md-icon-button" aria-label="more"
                                                           ng-click="ctrl.openMenu($mdOpenMenu, $event)">
                                                    <md-icon md-svg-icon="/icons/ic_more_vert_black_24px.svg"></md-icon>
                                                </md-button>
                                                <md-menu-content width="4">
                                                    <md-menu-item>
                                                        <md-button ng-click="ctrl.redial($event)">
                                                            <md-icon md-svg-icon="" md-menu-align-target></md-icon>
                                                            Redial
                                                        </md-button>
                                                    </md-menu-item>
                                                </md-menu-content>
                                            </md-menu>
                                        </span>
                                        <span class="md-subhead">
                                            @if($topic->tags != null)
                                                @foreach(explode(",",$topic->tags) as $tag)
                                                    <a href="/tag/{{$tag}}">
                                                        #{{ $tag }}
                                                    </a>
                                                @endforeach
                                            @endif

                                            <a href="/channel/{{ $topic->channel_slug }}">
                                                {{ $topic->channel_name }}
                                            </a>

                                            {!! \Carbon\Carbon::parse($topic->created_at)->diffForHumans() !!}

                                            @{{ 'KEY_VIEW' | translate }}  {{ $topic->views }}

                                            @{{ 'KEY_WNT_TO_KNOW' | translate }}  {{ $topic->follow }}
                                        </span>
                                    </md-card-title-text>
                                </md-card-title>

                                {{-- IF anon is 0 then display user information --}}
                                @if($topic->anon == 0)
                                <md-card-header>
                                    <md-card-avatar>
                                        <img class="md-user-avatar" src="https://scontent.fbkk8-1.fna.fbcdn.net/v/t1.0-1/p50x50/3768_10156694116535179_601632126662207422_n.jpg?oh=7708542c0f407b5a75b6603915be6e20&oe=57E3EBCC"/>
                                    </md-card-avatar>
                                    <md-card-header-text>
                                        <span class="md-title">Kantatorn Tardthong</span>
                                        <span class="md-subhead">
                                              @foreach(explode(",",$topic->tags) as $tag)
                                                <md-chip>
                                                    <a href="/tag/{{$tag}}">
                                                        {{ $tag }}
                                                    </a>
                                                </md-chip>
                                            @endforeach
                                        </span>
                                    </md-card-header-text>
                                    <span flex></span>

                                </md-card-header>
                                @endif

                                {{--<md-card-content>
                                    <p>
                                        The titles of Washed Out's breakthrough song and the first single from Paracosm share the
                                        two most important words in Ernest Greene's musical language: feel it. It's a simple request, as well...
                                    </p>
                                </md-card-content>--}}

                                <md-card-actions layout="row" layout-align="start center">

                                    <md-button aria-label="Favorite" class="md-icon-button">
                                        <md-icon md-svg-icon="/icons/ic_keyboard_arrow_up_black_24px.svg"></md-icon>
                                        <span>1</span>
                                    </md-button>


                                    <md-button aria-label="Settings" class="md-icon-button">
                                        <md-icon md-svg-icon="/icons/ic_keyboard_arrow_down_black_24px.svg"></md-icon>
                                        <span>1</span>
                                    </md-button>

                                    <span flex=""></span>

                                    <md-button>@{{ 'KEY_ANSWER' | translate }}  {{ $topic->answer }}</md-button>

                                    <span flex=""></span>

                                    <md-button>@{{ 'KEY_WNT_TO_KNOW' | translate }}  {{ $topic->follow }}</md-button>

                                    <span flex=""></span>

                                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                </md-card-actions>
                            </md-card>
                        @endforeach

                    </md-content>

                </md-tab>
                <md-tab label="@{{ 'KEY_NO_ANSWER' | translate }}">
                    <md-content class="md-padding">
                        <h1 class="md-display-2">Tab Two</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
                        <p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
                        <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
                    </md-content>
                </md-tab>
            </md-tabs>

        </div>
        <div flex hide-xs="true">

            @foreach($channels as $channel)
                <md-button flex>{!! $channel->name !!}</md-button>
            @endforeach

        </div>

    </div>
@endsection
