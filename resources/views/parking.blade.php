@extends('layout')

@section('content')
    <example-component></example-component>
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
{{--    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$clientLatLot}}&zoom=12&size=400x400&key=AIzaSyDLkNcYdF95IclSnT3Bmk_7lfqQAiUanB8">--}}
{{--    <img src="https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap--}}
{{--&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318--}}
{{--&markers=color:red%7Clabel:C%7C40.718217,-73.998284--}}
{{--&key=AIzaSyDLkNcYdF95IclSnT3Bmk_7lfqQAiUanB8">--}}
{{--</div>--}}
@endsection
