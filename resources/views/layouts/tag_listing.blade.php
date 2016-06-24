{{--
 Tags listing
 @params array $tags
--}}
<md-card>

    <md-list>

        <md-subheader class="md-no-sticky md-title">
            <i class="material-icons">trending_up</i>
            @{{ 'KEY_TRENDING' | translate }}
        </md-subheader>

        @foreach($tags as $tag)
            <md-list-item>
                <div class="md-list" layout="column">
                    <a href="/tag/{{ strip_tags($tag->title) }}">
                        #{{ strip_tags($tag->title) }}
                    </a>
                    <span class="md-secondary"> {{ $tag->tag_count }}</span>
                </div>
            </md-list-item>
        @endforeach

    </md-list>

</md-card>