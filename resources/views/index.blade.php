@extends('layouts.app')

@section('content')
<div class="container mt-5">
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('getWeather') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col-6">
        <input type="text" name="cityName" class="form-control" placeholder="Enter city name here (E.g New York)" value="{{ old('cityName', $cityName ?? '') }}">
      </div>
      <div class="col-6">
        <button type="submit" name="source" value="{{ \App\Services\WeatherService::SOURCE_API }}" class="btn btn-primary btn-block">Get from API</button>
        <button type="submit" name="source" value="{{ \App\Services\WeatherService::SOURCE_DB }}" class="btn btn-warning btn-block">Get from DB</button>
      </div>
    </div>
  </form>

  <hr>

  @if(isset($weather))
  <div class="card">
    <div class="card-body">
      <h1 class="card-title">{{ $weather['city_name'] }}</h1>
      @if($weather['type'] == \App\Services\WeatherService::SOURCE_DB)
        <h4>
          <b>Updated at: {{$weather['updated_at'] }}</b>
        <h4>
      @else
        <h4 class="card-title">Period</h4>
        <span>Starts at: {{ $weather['list'][0]['dt_txt'] }}</span>
        <form action="{{ route('save') }}" method="POST">
          @csrf
          <input type="hidden" name="cityName" value="{{ $weather['city_name'] }}">
          <input type="hidden" name="source" value="{{ \App\Services\WeatherService::SOURCE_API }}">
          <button type="submit" class="btn btn-success">Save forecast</button>
        </form>
      @endif
    </div>
  </div>

  <table class="table mt-4">
  <thead>
    <tr>
      <th scope="col">Date Time</th>
      <th scope="col">Min Temp</th>
      <th scope="col">Max Temp</th>
      <th scope="col">Wind speed</th>
    </tr>
  </thead>
  <tbody>
    @foreach($weather['list'] as $forecast)
    <tr>
      <th>{{ $forecast['dt_txt']}}</th>
      <td>{{ $forecast['main']['temp_min']}}</td>
      <td>{{ $forecast['main']['temp_min']}}</td>
      <td>{{ $forecast['wind']['speed']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>

  @endif
</div>
@endsection
