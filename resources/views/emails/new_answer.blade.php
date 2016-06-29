@extends('emails.layout')

@section('content')


<p class="md-headline">สว้สดีคุณ  {{ $follower->firstname }}  {{ $follower->lastname }}</p>

<p class="md-title">
มีคนตอบคำถาม <b>{{ strip_tags($follower->topic) }}</b>
อ่านรายละเอียดได้<a href="//www.qanya.com/answer/{{$topic->uuid}}">ที่นี่</a>

</p>

{{--{{ print_r($topic) }}--}}

จาก ทีม Qanya

<br>

<a href="www.qanya.com" class="md-body-1">Qanya.com</a>


@endsection

