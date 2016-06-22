{{-- LISTING TOPICS CARD --}}

@foreach($topics as $topic)

    <md-card layout="row">
        {{--{{ print_r($topic) }}--}}

        <div layout="column" layout-align="center center">


            <md-button class="md-icon-button" aria-label="Eat cake">
                <md-icon>
                    <i class="material-icons md-36">expand_less</i>
                </md-icon>
            </md-button>

            <span>{{ $topic->upvote - $topic->downvote }}</span>

            <md-button class="md-icon-button" aria-label="Eat cake">
                <md-icon>
                    <i class="material-icons md-36">expand_more</i>
                </md-icon>
            </md-button>

        </div>

        <div layout="column">
            <md-card-title>
                <md-card-title-text>
                    <span class="md-title">
                        <a href="/question/{{$topic->uuid}}">
                            {{ strip_tags($topic->topic) }}
                        </a>
                    </span>
                    <span class="md-subhead">
                        @{{ 'KEY_VIEW' | translate }}  {{ $topic->views }}
                        ·
                        @{{ 'KEY_WNT_TO_KNOW' | translate }}  {{ $topic->follow }}
                        ·
                        @{{ 'KEY_ANSWER' | translate }}  {{ $topic->answer }}
                        ·
                        <a href="/channel/{{ $topic->channel_slug }}" class="md-secondary">
                            {{ $topic->channel_name }}
                        </a>

                    </span>
                </md-card-title-text>
            </md-card-title>


            <md-card-content>

                <p class="md-body-1">

                    {!! str_limit(clean($topic->text),250) !!}

                    <a href="/profile/{{ $topic->displayname }}">
                        {{ '@'.$topic->displayname }}
                    </a>
                </p>

                <div>
                    @if($topic->tags != null)
                        @foreach(explode(",",$topic->tags) as $tag)
                            <a href="/tag/{{$tag}}">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    @endif
                </div>

            </md-card-content>


        </div>
    </md-card>

@endforeach