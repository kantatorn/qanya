@{{ 'KEY_RESET_PWD_CK' | translate }} <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
