@extends("app")

@section("page")

    <div class="container" style="position: center">
        <table class="table">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Email</th>
                <th>Компания</th>
                <th>Город</th>
                <th>Подтвержденный</th>
            </tr>
            </thead>
            @foreach ($users as $user)
                <tr>
                    <td style="max-width: 500px;">{{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}</td>
                    <td style="max-width: 500px;">{{ $user->email }}</td>
                    <td>{{ $user->company }}</td>
                    <td>{{ $user->city }}</td>
                    @if ($user->is_verified)
                        <td style="max-width: 500px;">Да</td>
                    @else
                        <td style="max-width: 500px;">Нет</td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
