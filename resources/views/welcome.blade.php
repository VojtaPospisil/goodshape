@extends('layout')

@section('content')
{{--    <form action="{{ route('apiParking') }}" method="get">--}}
    <form action="{{ route('getLocations') }}" method="get">
{{--        @csrf--}}
        <label for="ip">ip</label>
        <input id="ip" name="ip" type="checkbox">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude">
        <label for="longitude">Longitude</label>
        <input type="text" name="longitude">
        <label for="radius">vzdálenost Km</label>
        <input type="number" name="radius" required>
        <button type="submit" class="btn btn-primary">
            Vyhledat
        </button>
    </form>
@endsection


