<a href="{{ route('user.show', $user->id) }}">
    <img style="width: 150px;height: 150px;" src="{{ $user->gravatar('140') }}" alt="{{ $user->name }}" class="gravatar"/>
</a>
<h1>{{ $user->name }}</h1>