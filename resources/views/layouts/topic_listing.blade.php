{{-- LISTING TOPICS --}}

@foreach($topics as $topic)
    <md-list-item class="md-3-line">

        <div layout="column" layout-align="center center">


            <md-button class="md-icon-button" aria-label="Eat cake">
                <md-icon>
                    <i class="material-icons md-36">expand_less</i>
                </md-icon>
            </md-button>

            <span>10</span>

            <md-button class="md-icon-button" aria-label="Eat cake">
                <md-icon>
                    <i class="material-icons md-36">expand_more</i>
                </md-icon>
            </md-button>

        </div>
        <div class="md-list-item-text" layout="column">

            <h3>
                <a href="/question/{{$topic->uuid}}" class="md-title">
                    {{ strip_tags($topic->topic) }}
                </a>
            </h3>

            <h4>
                @{{ 'KEY_VIEW' | translate }}  {{ $topic->views }}
                @{{ 'KEY_WNT_TO_KNOW' | translate }}  {{ $topic->follow }}
                @{{ 'KEY_ANSWER' | translate }}  {{ $topic->answer }}
            </h4>
            <p>
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
            </p>
        </div>

    </md-list-item>
@endforeach