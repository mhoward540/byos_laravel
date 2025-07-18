@props(['size' => 'full'])
@php
    $city = $data['city']['name'] ?? 'Vienna';

    // Group forecast entries by day
    $forecastsByDay = [];
    $todaysDate = null;
    foreach ($data['list'] ?? [] as $forecast) {
        $date = substr($forecast['dt_txt'], 0, 10); // Extract date part (YYYY-MM-DD)
        if ($todaysDate === null) {
            $todaysDate = $date;
        }
        if (!isset($forecastsByDay[$date])) {
            $forecastsByDay[$date] = [];
        }
        $forecastsByDay[$date][] = $forecast;
    }

    $nextFourHours = array_slice($data['list'], 0, 3);
@endphp
{{--@dump($nextFourHours)--}}

<x-trmnl::view size="{{$size}}">
    <x-trmnl::layout class="layout--col gap--space-between">
        <div class="grid" style="gap: 9px;">
            <div id="hero-weather" class="layout--col">
                <img src="https://openweathermap.org/img/wn/{{$nextFourHours[0]['weather'][0]['icon']}}@2x.png" alt="Weather Icon" class="weather-image" style="max-height: 150px; margin:auto;">
            </div>
        </div>
    </x-trmnl::layout>
    <x-trmnl::title-bar title="Weather {{ $city }}" instance="updated: {{now()}}"/>
</x-trmnl::view>

