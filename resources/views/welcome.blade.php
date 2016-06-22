@extends('layouts.app')

@section('content')


    <div layout="row" layout-align="center" class="layoutSingleColumn">
        <div flex="100" flex-gt-xs="60">
            <md-tabs md-dynamic-height md-border-bottom>

                {{-- If user login show customize feed--}}
                @if(Auth::user())

                <md-tab label="For you">
                    <md-content class="md-padding">
                        @include('layouts.topic_listing', ['topics' => $channelFeed])
                    </md-content>
                </md-tab>

                @endif


                {{-- Questions listing --}}
                <md-tab label="@{{ 'KEY_MSTVIEW_TDAY' | translate }}">
                    <md-content>
                        @include('layouts.topic_listing', ['topics' => $topics])
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

                {{-- NO ANSWERS TAB--}}
                <md-tab label="@{{ 'KEY_NO_ANSWER' | translate }}">

                    <md-content class="md-padding">
                        @include('layouts.topic_listing', ['topics' => $noAnswers])
                    </md-content>

                </md-tab>
            </md-tabs>

        </div>

        {{-- LEFT SIDE CHANNEL AND USER CARD, HIDE ON XS --}}
        <div flex hide-xs="true">

            @if(Auth::user())
                <md-card md-theme="blue" md-theme-watch>
                    <md-card-title>
                        <md-card-title-text>
                            <span class="md-title">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }} </span>
                            <span class="md-subhead">{{ '@'.Auth::user()->displayname }}</span>
                        </md-card-title-text>
                        <md-card-title-media>
                            <div class="md-media-sm card-media">
                                <img src="{{ Auth::user()->avatar }}">
                            </div>
                        </md-card-title-media>
                    </md-card-title>
                    <md-card-actions layout="row" layout-align="end center">
                        <md-button>Action 1</md-button>
                        <md-button>Action 2</md-button>
                    </md-card-actions>
                </md-card>
            @endif

            {{-- CHANNEL LISTING --}}
            @foreach($channels as $channel)
                <md-button ng-href="/channel/{{ $channel->slug }}">{!! $channel->name !!}</md-button>
            @endforeach


            {{-- TRENDING --}}
            @include('layouts.tag_listing', ['tags' => $trendingTags])
            

        </div>

    </div>
@endsection
