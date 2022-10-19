@component('mail::message')

# User Created

## Welcome, {{ $user->name  }}

## Your login: {{ $user->email }}</br>
## Your password: {{ $user->password }}</br>

@component('mail::button', ['url' => $url, 'color' => 'success'])
Back to sitepage
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
