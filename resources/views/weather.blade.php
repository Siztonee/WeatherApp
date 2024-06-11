<!DOCTYPE html>
<html>
    <head>
        <title>Weather App</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body>
    <div class="container">
        <h1 class="mt-5">Weather App</h1>
        <form method="POST" action="/">
            @csrf
            <div class="form-group">
                <label for="city">Enter city name:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <button type="submit" class="btn btn-primary">Get Weather</button>
        </form>

        @isset($weather)
            <div class="weather-card mt-5">
                <h2>Weather in {{ $weather['name'] }}</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="icon">
                            <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="Weather Icon">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="temp">{{ $weather['main']['temp'] }} °C</div>
                        <div class="description">{{ $weather['weather'][0]['description'] }}</div>
                        <p>Humidity: {{ $weather['main']['humidity'] }}%</p>
                        <p>Wind Speed: {{ $weather['wind']['speed'] }} m/s</p>
                    </div>
                </div>
            </div>

            <div class="hourly-weather mt-5">
                <h3>Hourly Forecast</h3>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($hourlyWeather as $hour)
                            <div class="swiper-slide">
                                <p>{{ \Carbon\Carbon::createFromTimestamp($hour['dt'])->format('H:i') }}</p>
                                <p><img src="http://openweathermap.org/img/wn/{{ $hour['weather'][0]['icon'] }}.png" alt="Weather Icon"></p>
                                <p>{{ $hour['main']['temp'] }} °C</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        @endisset

        @isset($error)
            <div class="alert alert-danger mt-5">
                {{ $error }}
            </div>
        @endisset
    </div>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    </body>
</html>
