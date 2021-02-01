@extends('layout')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>id</th>
                <th>Název</th>
                <th>Celkově míst</th>
                <th>Volných míst</th>
            </tr>
            </thead>
            <tbody>
            @foreach($parkingPlaces as $parking)
                <tr>
                    <td>{{ $parking->id }}</td>
                    <td>{{ $parking->name }}</td>
                    <td>{{ $parking->totalNumOfPlaces }}</td>
                    <td>{{ $parking->numOfFreePlaces }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $parkingPlaces->links() }}
    </div>
<div>
    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$clientLatLot}}&zoom=12&size=400x400&key=AIzaSyDLkNcYdF95IclSnT3Bmk_7lfqQAiUanB8">
</div>
@endsection
