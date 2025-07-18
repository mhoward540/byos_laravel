
@props(['size' => 'full'])
@php
    // Extract current weather data
    $currentWeather = $data['properties']['timeseries'][0] ?? null;
    $temperature = $currentWeather['data']['instant']['details']['air_temperature'] ?? null;
    $temperatureFahrenheit = $temperature !== null ? round(($temperature * 9/5) + 32, 1) : null;
    $humidity = $currentWeather['data']['instant']['details']['relative_humidity'] ?? null;
    $conditions = $currentWeather['data']['next_1_hours']['summary']['symbol_code'] ?? 'clear';
    $windSpeed = $currentWeather['data']['instant']['details']['wind_speed'] ?? null;

    // Map symbol codes to weather images
    $weatherImageMap = [
        'clear' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M375.7 19.7c-1.5-8-6.9-14.7-14.4-17.8s-16.1-2.2-22.8 2.4L256 61.1 173.5 4.2c-6.7-4.6-15.3-5.5-22.8-2.4s-12.9 9.8-14.4 17.8l-18.1 98.5L19.7 136.3c-8 1.5-14.7 6.9-17.8 14.4s-2.2 16.1 2.4 22.8L61.1 256 4.2 338.5c-4.6 6.7-5.5 15.3-2.4 22.8s9.8 13 17.8 14.4l98.5 18.1 18.1 98.5c1.5 8 6.9 14.7 14.4 17.8s16.1 2.2 22.8-2.4L256 450.9l82.5 56.9c6.7 4.6 15.3 5.5 22.8 2.4s12.9-9.8 14.4-17.8l18.1-98.5 98.5-18.1c8-1.5 14.7-6.9 17.8-14.4s2.2-16.1-2.4-22.8L450.9 256l56.9-82.5c4.6-6.7 5.5-15.3 2.4-22.8s-9.8-12.9-17.8-14.4l-98.5-18.1L375.7 19.7zM269.6 110l65.6-45.2 14.4 78.3c1.8 9.8 9.5 17.5 19.3 19.3l78.3 14.4L402 242.4c-5.7 8.2-5.7 19 0 27.2l45.2 65.6-78.3 14.4c-9.8 1.8-17.5 9.5-19.3 19.3l-14.4 78.3L269.6 402c-8.2-5.7-19-5.7-27.2 0l-65.6 45.2-14.4-78.3c-1.8-9.8-9.5-17.5-19.3-19.3L64.8 335.2 110 269.6c5.7-8.2 5.7-19 0-27.2L64.8 176.8l78.3-14.4c9.8-1.8 17.5-9.5 19.3-19.3l14.4-78.3L242.4 110c8.2 5.7 19 5.7 27.2 0zM256 368a112 112 0 1 0 0-224 112 112 0 1 0 0 224zM192 256a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"/></svg>',
        'partlycloudy_day' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M294.2 1.2c5.1 2.1 8.7 6.7 9.6 12.1l14.1 84.7 84.7 14.1c5.4 .9 10 4.5 12.1 9.6s1.5 10.9-1.6 15.4l-38.5 55c-2.2-.1-4.4-.2-6.7-.2c-23.3 0-45.1 6.2-64 17.1l0-1.1c0-53-43-96-96-96s-96 43-96 96s43 96 96 96c8.1 0 15.9-1 23.4-2.9c-36.6 18.1-63.3 53.1-69.8 94.9l-24.4 17c-4.5 3.2-10.3 3.8-15.4 1.6s-8.7-6.7-9.6-12.1L98.1 317.9 13.4 303.8c-5.4-.9-10-4.5-12.1-9.6s-1.5-10.9 1.6-15.4L52.5 208 2.9 137.2c-3.2-4.5-3.8-10.3-1.6-15.4s6.7-8.7 12.1-9.6L98.1 98.1l14.1-84.7c.9-5.4 4.5-10 9.6-12.1s10.9-1.5 15.4 1.6L208 52.5 278.8 2.9c4.5-3.2 10.3-3.8 15.4-1.6zM144 208a64 64 0 1 1 128 0 64 64 0 1 1 -128 0zM639.9 431.9c0 44.2-35.8 80-80 80l-271.9 0c-53 0-96-43-96-96c0-47.6 34.6-87 80-94.6l0-1.3c0-53 43-96 96-96c34.9 0 65.4 18.6 82.2 46.4c13-9.1 28.8-14.4 45.8-14.4c44.2 0 80 35.8 80 80c0 5.9-.6 11.7-1.9 17.2c37.4 6.7 65.8 39.4 65.8 78.7z"/></svg>',
        'partlycloudy_night' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M495.8 0c5.5 0 10.9 .2 16.3 .7c7 .6 12.8 5.7 14.3 12.5s-1.6 13.9-7.7 17.3c-44.4 25.2-74.4 73-74.4 127.8c0 81 65.5 146.6 146.2 146.6c8.6 0 17-.7 25.1-2.1c6.9-1.2 13.8 2.2 17 8.5s1.9 13.8-3.1 18.7c-34.5 33.6-81.7 54.4-133.6 54.4c-9.3 0-18.4-.7-27.4-1.9c-11.2-22.6-29.8-40.9-52.6-51.7c-2.7-58.5-50.3-105.3-109.2-106.7c-1.7-10.4-2.6-21-2.6-31.8C304 86.1 389.8 0 495.8 0zM447.9 431.9c0 44.2-35.8 80-80 80L96 511.9c-53 0-96-43-96-96c0-47.6 34.6-87 80-94.6l0-1.3c0-53 43-96 96-96c34.9 0 65.4 18.6 82.2 46.4c13-9.1 28.8-14.4 45.8-14.4c44.2 0 80 35.8 80 80c0 5.9-.6 11.7-1.9 17.2c37.4 6.7 65.8 39.4 65.8 78.7z"/></svg>',
        'cloudy' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 336c0 79.5 64.5 144 144 144l368 0c70.7 0 128-57.3 128-128c0-61.9-44-113.6-102.4-125.4c4.1-10.7 6.4-22.4 6.4-34.6c0-53-43-96-96-96c-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32C167.6 32 96 103.6 96 192c0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336z"/></svg>',
        'rain' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M192 512C86 512 0 426 0 320C0 228.8 130.2 57.7 166.6 11.7C172.6 4.2 181.5 0 191.1 0l1.8 0c9.6 0 18.5 4.2 24.5 11.7C253.8 57.7 384 228.8 384 320c0 106-86 192-192 192zM96 336c0-8.8-7.2-16-16-16s-16 7.2-16 16c0 61.9 50.1 112 112 112c8.8 0 16-7.2 16-16s-7.2-16-16-16c-44.2 0-80-35.8-80-80z"/></svg>',
        'lightrain' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 320c-53 0-96-43-96-96c0-42.5 27.6-78.6 65.9-91.2C64.7 126.1 64 119.1 64 112C64 50.1 114.1 0 176 0c43.1 0 80.5 24.3 99.2 60c14.7-17.1 36.5-28 60.8-28c44.2 0 80 35.8 80 80c0 5.5-.6 10.8-1.6 16c.5 0 1.1 0 1.6 0c53 0 96 43 96 96s-43 96-96 96L96 320zm-6.8 52c1.3-2.5 3.9-4 6.8-4s5.4 1.5 6.8 4l35.1 64.6c4.1 7.5 6.2 15.8 6.2 24.3l0 3c0 26.5-21.5 48-48 48s-48-21.5-48-48l0-3c0-8.5 2.1-16.9 6.2-24.3L89.2 372zm160 0c1.3-2.5 3.9-4 6.8-4s5.4 1.5 6.8 4l35.1 64.6c4.1 7.5 6.2 15.8 6.2 24.3l0 3c0 26.5-21.5 48-48 48s-48-21.5-48-48l0-3c0-8.5 2.1-16.9 6.2-24.3L249.2 372zm124.9 64.6L409.2 372c1.3-2.5 3.9-4 6.8-4s5.4 1.5 6.8 4l35.1 64.6c4.1 7.5 6.2 15.8 6.2 24.3l0 3c0 26.5-21.5 48-48 48s-48-21.5-48-48l0-3c0-8.5 2.1-16.9 6.2-24.3z"/></svg>',
        'heavyrain' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 0c38.6 0 71.9 22.8 87.2 55.7C325.7 41.1 345.8 32 368 32c38.7 0 71 27.5 78.4 64l1.6 0c35.3 0 64 28.7 64 64s-28.7 64-64 64l-320 0c-35.3 0-64-28.7-64-64s28.7-64 64-64c0-53 43-96 96-96zM140.6 292.3l-48 80c-6.8 11.4-21.6 15-32.9 8.2s-15.1-21.6-8.2-32.9l48-80c6.8-11.4 21.6-15.1 32.9-8.2s15.1 21.6 8.2 32.9zm327.8-32.9c11.4 6.8 15 21.6 8.2 32.9l-48 80c-6.8 11.4-21.6 15-32.9 8.2s-15-21.6-8.2-32.9l48-80c6.8-11.4 21.6-15.1 32.9-8.2zM252.6 292.3l-48 80c-6.8 11.4-21.6 15-32.9 8.2s-15.1-21.6-8.2-32.9l48-80c6.8-11.4 21.6-15.1 32.9-8.2s15.1 21.6 8.2 32.9zm103.8-32.9c11.4 6.8 15 21.6 8.2 32.9l-48 80c-6.8 11.4-21.6 15-32.9 8.2s-15.1-21.6-8.2-32.9l48-80c6.8-11.4 21.6-15.1 32.9-8.2zM306.5 421.9C329 437.4 356.5 448 384 448c26.9 0 55.4-10.8 77.4-26.1c0 0 0 0 0 0c11.9-8.5 28.1-7.8 39.2 1.7c14.4 11.9 32.5 21 50.6 25.2c17.2 4 27.9 21.2 23.9 38.4s-21.2 27.9-38.4 23.9c-24.5-5.7-44.9-16.5-58.2-25C449.5 501.7 417 512 384 512c-31.9 0-60.6-9.9-80.4-18.9c-5.8-2.7-11.1-5.3-15.6-7.7c-4.5 2.4-9.7 5.1-15.6 7.7c-19.8 9-48.5 18.9-80.4 18.9c-33 0-65.5-10.3-94.5-25.8c-13.4 8.4-33.7 19.3-58.2 25c-17.2 4-34.4-6.7-38.4-23.9s6.7-34.4 23.9-38.4c18.1-4.2 36.2-13.3 50.6-25.2c11.1-9.4 27.3-10.1 39.2-1.7c0 0 0 0 0 0C136.7 437.2 165.1 448 192 448c27.5 0 55-10.6 77.5-26.1c11.1-7.9 25.9-7.9 37 0z"/></svg>',
        'rainshowers_day' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M294.2 1.2c5.1 2.1 8.7 6.7 9.6 12.1l10.4 62.4c-23.3 10.8-42.9 28.4-56 50.3c-14.6-9-31.8-14.1-50.2-14.1c-53 0-96 43-96 96c0 35.5 19.3 66.6 48 83.2c.8 31.8 13.2 60.7 33.1 82.7l-56 39.2c-4.5 3.2-10.3 3.8-15.4 1.6s-8.7-6.7-9.6-12.1L98.1 317.9 13.4 303.8c-5.4-.9-10-4.5-12.1-9.6s-1.5-10.9 1.6-15.4L52.5 208 2.9 137.2c-3.2-4.5-3.8-10.3-1.6-15.4s6.7-8.7 12.1-9.6L98.1 98.1l14.1-84.7c.9-5.4 4.5-10 9.6-12.1s10.9-1.5 15.4 1.6L208 52.5 278.8 2.9c4.5-3.2 10.3-3.8 15.4-1.6zM208 144c13.8 0 26.7 4.4 37.1 11.9c-1.2 4.1-2.2 8.3-3 12.6c-37.9 14.6-67.2 46.6-77.8 86.4C151.8 243.1 144 226.5 144 208c0-35.3 28.7-64 64-64zm69.4 276c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm74.5-116.1c0 44.2-35.8 80-80 80l-271.9 0c-53 0-96-43-96-96c0-47.6 34.6-87 80-94.6l0-1.3c0-53 43-96 96-96c34.9 0 65.4 18.6 82.2 46.4c13-9.1 28.8-14.4 45.8-14.4c44.2 0 80 35.8 80 80c0 5.9-.6 11.7-1.9 17.2c37.4 6.7 65.8 39.4 65.8 78.7z"/></svg>',
        'rainshowers_night' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M481.2 0C417 0 363.5 46.5 353.7 107.6c35.4 17.6 60.2 53.3 62.1 95.1c23.2 11 42 29.7 53.1 52.7c4 .4 8.1 .6 12.3 .6c34.9 0 66.7-13.8 89.9-36.1c5.1-4.9 6.4-12.5 3.2-18.7s-10.1-9.7-17-8.6c-4.9 .8-10 1.3-15.2 1.3c-49 0-88.4-39.3-88.4-87.4c0-32.6 18-61.1 44.9-76.1c6.1-3.4 9.3-10.5 7.8-17.4s-7.3-12-14.3-12.6c-3.6-.3-7.3-.5-10.9-.5zM367.9 383.9c44.2 0 80-35.8 80-80c0-39.3-28.4-72.1-65.8-78.7c1.2-5.6 1.9-11.3 1.9-17.2c0-44.2-35.8-80-80-80c-17 0-32.8 5.3-45.8 14.4C241.3 114.6 210.8 96 176 96c-53 0-96 43-96 96l0 1.3c-45.4 7.6-80 47.1-80 94.6c0 53 43 96 96 96l271.9 0zM85.4 420.1c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3z"/></svg>',
        'lightrainshowers_day' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M294.2 1.2c5.1 2.1 8.7 6.7 9.6 12.1l10.4 62.4c-23.3 10.8-42.9 28.4-56 50.3c-14.6-9-31.8-14.1-50.2-14.1c-53 0-96 43-96 96c0 35.5 19.3 66.6 48 83.2c.8 31.8 13.2 60.7 33.1 82.7l-56 39.2c-4.5 3.2-10.3 3.8-15.4 1.6s-8.7-6.7-9.6-12.1L98.1 317.9 13.4 303.8c-5.4-.9-10-4.5-12.1-9.6s-1.5-10.9 1.6-15.4L52.5 208 2.9 137.2c-3.2-4.5-3.8-10.3-1.6-15.4s6.7-8.7 12.1-9.6L98.1 98.1l14.1-84.7c.9-5.4 4.5-10 9.6-12.1s10.9-1.5 15.4 1.6L208 52.5 278.8 2.9c4.5-3.2 10.3-3.8 15.4-1.6zM208 144c13.8 0 26.7 4.4 37.1 11.9c-1.2 4.1-2.2 8.3-3 12.6c-37.9 14.6-67.2 46.6-77.8 86.4C151.8 243.1 144 226.5 144 208c0-35.3 28.7-64 64-64zm69.4 276c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm96 0c11 7.4 14 22.3 6.7 33.3l-32 48c-7.4 11-22.3 14-33.3 6.7s-14-22.3-6.7-33.3l32-48c7.4-11 22.3-14 33.3-6.7zm74.5-116.1c0 44.2-35.8 80-80 80l-271.9 0c-53 0-96-43-96-96c0-47.6 34.6-87 80-94.6l0-1.3c0-53 43-96 96-96c34.9 0 65.4 18.6 82.2 46.4c13-9.1 28.8-14.4 45.8-14.4c44.2 0 80 35.8 80 80c0 5.9-.6 11.7-1.9 17.2c37.4 6.7 65.8 39.4 65.8 78.7z"/></svg>',
        'lightrainshowers_night' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M481.2 0C417 0 363.5 46.5 353.7 107.6c35.4 17.6 60.2 53.3 62.1 95.1c23.2 11 42 29.7 53.1 52.7c4 .4 8.1 .6 12.3 .6c34.9 0 66.7-13.8 89.9-36.1c5.1-4.9 6.4-12.5 3.2-18.7s-10.1-9.7-17-8.6c-4.9 .8-10 1.3-15.2 1.3c-49 0-88.4-39.3-88.4-87.4c0-32.6 18-61.1 44.9-76.1c6.1-3.4 9.3-10.5 7.8-17.4s-7.3-12-14.3-12.6c-3.6-.3-7.3-.5-10.9-.5zM367.9 383.9c44.2 0 80-35.8 80-80c0-39.3-28.4-72.1-65.8-78.7c1.2-5.6 1.9-11.3 1.9-17.2c0-44.2-35.8-80-80-80c-17 0-32.8 5.3-45.8 14.4C241.3 114.6 210.8 96 176 96c-53 0-96 43-96 96l0 1.3c-45.4 7.6-80 47.1-80 94.6c0 53 43 96 96 96l271.9 0zM85.4 420.1c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3zm96 0c-11-7.4-25.9-4.4-33.3 6.7l-32 48c-7.4 11-4.4 25.9 6.7 33.3s25.9 4.4 33.3-6.7l32-48c7.4-11 4.4-25.9-6.7-33.3z"/></svg>',
        'snow' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 0c17.7 0 32 14.3 32 32l0 30.1 15-15c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-49 49 0 70.3 61.4-35.8 17.7-66.1c3.4-12.8 16.6-20.4 29.4-17s20.4 16.6 17 29.4l-5.2 19.3 23.6-13.8c15.3-8.9 34.9-3.7 43.8 11.5s3.8 34.9-11.5 43.8l-25.3 14.8 21.7 5.8c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17l-67.7-18.1L287.5 256l60.9 35.5 67.7-18.1c12.8-3.4 26 4.2 29.4 17s-4.2 26-17 29.4l-21.7 5.8 25.3 14.8c15.3 8.9 20.4 28.5 11.5 43.8s-28.5 20.4-43.8 11.5l-23.6-13.8 5.2 19.3c3.4 12.8-4.2 26-17 29.4s-26-4.2-29.4-17l-17.7-66.1L256 311.7l0 70.3 49 49c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-15-15 0 30.1c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-30.1-15 15c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l49-49 0-70.3-61.4 35.8-17.7 66.1c-3.4 12.8-16.6 20.4-29.4 17s-20.4-16.6-17-29.4l5.2-19.3L48.1 395.6c-15.3 8.9-34.9 3.7-43.8-11.5s-3.7-34.9 11.5-43.8l25.3-14.8-21.7-5.8c-12.8-3.4-20.4-16.6-17-29.4s16.6-20.4 29.4-17l67.7 18.1L160.5 256 99.6 220.5 31.9 238.6c-12.8 3.4-26-4.2-29.4-17s4.2-26 17-29.4l21.7-5.8L15.9 171.6C.6 162.7-4.5 143.1 4.4 127.9s28.5-20.4 43.8-11.5l23.6 13.8-5.2-19.3c-3.4-12.8 4.2-26 17-29.4s26 4.2 29.4 17l17.7 66.1L192 200.3l0-70.3L143 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l15 15L192 32c0-17.7 14.3-32 32-32z"/></svg>',
        'fog' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M32 144c0 79.5 64.5 144 144 144l123.3 0c22.6 19.9 52.2 32 84.7 32s62.1-12.1 84.7-32l27.3 0c61.9 0 112-50.1 112-112s-50.1-112-112-112c-10.7 0-21 1.5-30.8 4.3C443.8 27.7 401.1 0 352 0c-32.6 0-62.4 12.2-85.1 32.3C242.1 12.1 210.5 0 176 0C96.5 0 32 64.5 32 144zM616 368l-336 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l336 0c13.3 0 24-10.7 24-24s-10.7-24-24-24zm-64 96l-112 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24zm-192 0L24 464c-13.3 0-24 10.7-24 24s10.7 24 24 24l336 0c13.3 0 24-10.7 24-24s-10.7-24-24-24zM224 392c0-13.3-10.7-24-24-24L96 368c-13.3 0-24 10.7-24 24s10.7 24 24 24l104 0c13.3 0 24-10.7 24-24z"/></svg>'
    ];

    $weatherImage = $weatherImageMap[$conditions] ?? $weatherImageMap['clear'];

    // Group timeseries data by day for forecast
    $forecastsByDay = [];
    foreach ($data['properties']['timeseries'] ?? [] as $entry) {
        $date = substr($entry['time'], 0, 10); // Extract YYYY-MM-DD
        if (!isset($forecastsByDay[$date])) {
            $forecastsByDay[$date] = [];
        }
        $forecastsByDay[$date][] = $entry;
    }

    $days = array_keys($forecastsByDay);
    $today = $days[0] ?? null;
    $tomorrow = $days[1] ?? null;

    // Calculate today's min/max temperatures
    $todayTemps = [];
    $todayConditions = null;
    if ($today && isset($forecastsByDay[$today])) {
        foreach ($forecastsByDay[$today] as $entry) {
            $temp = $entry['data']['instant']['details']['air_temperature'] ?? null;
            if ($temp !== null) {
                $todayTemps[] = $temp;
            }
            if (!$todayConditions && isset($entry['data']['next_12_hours']['summary']['symbol_code'])) {
                $todayConditions = $entry['data']['next_12_hours']['summary']['symbol_code'];
            }
        }
    }

    // Calculate tomorrow's min/max temperatures
    $tomorrowTemps = [];
    $tomorrowConditions = null;
    if ($tomorrow && isset($forecastsByDay[$tomorrow])) {
        foreach ($forecastsByDay[$tomorrow] as $entry) {
            $temp = $entry['data']['instant']['details']['air_temperature'] ?? null;
            if ($temp !== null) {
                $tomorrowTemps[] = $temp;
            }
            if (!$tomorrowConditions && isset($entry['data']['next_12_hours']['summary']['symbol_code'])) {
                $tomorrowConditions = $entry['data']['next_12_hours']['summary']['symbol_code'];
            }
        }
    }

    $todayMin = !empty($todayTemps) ? min($todayTemps) : null;
    $todayMax = !empty($todayTemps) ? max($todayTemps) : null;
    $tomorrowMin = !empty($tomorrowTemps) ? min($tomorrowTemps) : null;
    $tomorrowMax = !empty($tomorrowTemps) ? max($tomorrowTemps) : null;

    $todayWeatherImage = $weatherImageMap[$todayConditions] ?? $weatherImageMap['clear'];
    $tomorrowWeatherImage = $weatherImageMap[$tomorrowConditions] ?? $weatherImageMap['clear'];

    // Format condition names
    $conditionsFormatted = ucwords(str_replace('_', ' ', $conditions));
    $todayConditionsFormatted = ucwords(str_replace('_', ' ', $todayConditions));
    $tomorrowConditionsFormatted = ucwords(str_replace('_', ' ', $tomorrowConditions));

    $feelsLikeIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 64c-26.5 0-48 21.5-48 48l0 164.5c0 17.3-7.1 31.9-15.3 42.5C86.2 332.6 80 349.5 80 368c0 44.2 35.8 80 80 80s80-35.8 80-80c0-18.5-6.2-35.4-16.7-48.9c-8.2-10.6-15.3-25.2-15.3-42.5L208 112c0-26.5-21.5-48-48-48zM48 112C48 50.2 98.1 0 160 0s112 50.1 112 112l0 164.4c0 .1 .1 .3 .2 .6c.2 .6 .8 1.6 1.7 2.8c18.9 24.4 30.1 55 30.1 88.1c0 79.5-64.5 144-144 144S16 447.5 16 368c0-33.2 11.2-63.8 30.1-88.1c.9-1.2 1.5-2.2 1.7-2.8c.1-.3 .2-.5 .2-.6L48 112zM208 368c0 26.5-21.5 48-48 48s-48-21.5-48-48c0-20.9 13.4-38.7 32-45.3L144 208c0-8.8 7.2-16 16-16s16 7.2 16 16l0 114.7c18.6 6.6 32 24.4 32 45.3z"/></svg>'
@endphp

<style>
    .view--full .weather-image {
        width: 180px;
    }

    .view--full .weather-icon {
        width: 50px;
    }

    .view--full .weather-icon {
        width: 50px;
    }

    .view--full .weather-icon svg {
        width: 100%;
        height: 100%;
    }

    .view--quadrant .weather-image {
        width: 170px;
    }

    /* was 298 before forecast */
    .view--half_vertical .weather-image {
        width: 288px;
    }

    .view--half_horizontal .weather-image {
        width: 170px;
    }
</style>

<div class="view view--{{ $size }}">
    <div class="layout layout--col gap--space-between">
        <div class="grid">
            <div class="row row--center col--span-3 col--end">
                <div class="weather-image">
                    {!! $weatherImage !!}
                </div>
            </div>
            <div class="col col--span-3 col--end">
                <div class="item h--full">
                    <div class="meta"></div>
                    <div class="content">
                        <span class="value value--xxxlarge" data-fit-value="true">{{ $temperature ? round($temperature, 1) : 'N/A' }}°</span>
                        <span class="label">Temperature ({{$temperatureFahrenheit}}°F)</span>
                    </div>
                </div>
            </div>
            <div class="col col--span-3 col--end gap--medium">
                <div class="item">
                    <div class="meta"></div>
                    <div class="icon">
                        <div class="weather-icon">
                            {!! $feelsLikeIcon !!}
                        </div>
                    </div>
                    <div class="content">
                        <span class="value value--small">{{ $temperature ? round($temperature) : 'N/A' }}°</span>
                        <span class="label">Feels Like</span>
                    </div>
                </div>

                <div class="item">
                    <div class="meta"></div>
                    <div class="icon">
                        <div class="weather-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/></svg>
                        </div>
                    </div>
                    <div class="content">
                        <span class="value value--small">{{ $humidity ? round($humidity) : 'N/A' }}%</span>
                        <span class="label">Humidity</span>
                    </div>
                </div>

                <div class="item">
                    <div class="meta"></div>
                    <div class="icon">
                        <div class="weather-icon">
                            {!! $weatherImage !!}
                        </div>
                    </div>
                    <div class="content">
                        <span class="value value--xsmall">{{ $conditionsFormatted }}</span>
                        <span class="label">Right Now</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full b-h-gray-5"></div>

        <div class="grid">
            <div class="col gap--large">
                <div class="grid">
                    <div class="item col--span-3">
                        <div class="meta"></div>
                        <div class="icon">
                            <div class="weather-icon">
                                {!! $todayWeatherImage !!}
                            </div>
                        </div>
                        <div class="content">
                            <span class="value value--xsmall">{{ $todayConditionsFormatted }}</span>
                            <span class="label">Today</span>
                        </div>
                    </div>

                    <div class="item col--span-3">
                        <div class="meta"></div>
                        <div class="icon">
                            <div class="weather-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c0 17.7 14.3 32 32 32l32 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128c-17.7 0-32 14.3-32 32s14.3 32 32 32l320 0c53 0 96-43 96-96s-43-96-96-96L320 0c-17.7 0-32 14.3-32 32zm64 352c0 17.7 14.3 32 32 32l32 0c53 0 96-43 96-96s-43-96-96-96L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0c-17.7 0-32 14.3-32 32zM128 512l32 0c53 0 96-43 96-96s-43-96-96-96L32 320c-17.7 0-32 14.3-32 32s14.3 32 32 32l128 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32z"/></svg>
                            </div>
                        </div>
                        <div class="content">
                            <span class="value value--xsmall">{{ $windSpeed ? round($windSpeed) : 'N/A' }} m/s</span>
                            <span class="label">Wind Speed</span>
                        </div>
                    </div>

                    <div class="row col--span-3">
                        <div class="item">
                            <div class="meta"></div>
                            <div class="icon">
                                <div class="weather-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 64c-26.5 0-48 21.5-48 48l0 164.5c0 17.3-7.1 31.9-15.3 42.5C86.2 332.6 80 349.5 80 368c0 44.2 35.8 80 80 80s80-35.8 80-80c0-18.5-6.2-35.4-16.7-48.9c-8.2-10.6-15.3-25.2-15.3-42.5L208 112c0-26.5-21.5-48-48-48zM48 112C48 50.2 98.1 0 160 0s112 50.1 112 112l0 164.4c0 .1 .1 .3 .2 .6c.2 .6 .8 1.6 1.7 2.8c18.9 24.4 30.1 55 30.1 88.1c0 79.5-64.5 144-144 144S16 447.5 16 368c0-33.2 11.2-63.8 30.1-88.1c.9-1.2 1.5-2.2 1.7-2.8c.1-.3 .2-.5 .2-.6L48 112zM208 368c0 26.5-21.5 48-48 48s-48-21.5-48-48c0-20.9 13.4-38.7 32-45.3L144 208c0-8.8 7.2-16 16-16s16 7.2 16 16l0 114.7c18.6 6.6 32 24.4 32 45.3z"/></svg>
                                </div>
                            </div>
                            <div class="row">
                                <div class="content w--20">
                                    <span class="value value--small">{{ $todayMin ? round($todayMin) : 'N/A' }}°</span>
                                    <span class="label">Low</span>
                                </div>
                                <div class="content w--20">
                                    <span class="value value--small">{{ $todayMax ? round($todayMax) : 'N/A' }}°</span>
                                    <span class="label">High</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="item col--span-3">
                        <div class="meta"></div>
                        <div class="icon">
                            <div class="weather-icon">
                                {!! $tomorrowWeatherImage !!}
                            </div>
                        </div>
                        <div class="content">
                            <span class="value value--xsmall">{{ $tomorrowConditionsFormatted }}</span>
                            <span class="label">Tomorrow</span>
                        </div>
                    </div>

                    <div class="item col--span-3">
                        <div class="meta"></div>
                        <div class="icon">
                            <div class="weather-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M153.6 29.9l16-21.3C173.6 3.2 180 0 186.7 0C198.4 0 208 9.6 208 21.3V43.5c0 13.1 5.4 25.7 14.9 34.7L307.6 159C356.4 205.6 384 270.2 384 337.7C384 434 306 512 209.7 512H192C86 512 0 426 0 320v-3.8c0-48.8 19.4-95.6 53.9-130.1l3.5-3.5c4.2-4.2 10-6.6 16-6.6C85.9 176 96 186.1 96 198.6V288c0 35.3 28.7 64 64 64s64-28.7 64-64v-3.9c0-18-7.2-35.3-19.9-48l-38.6-38.6c-24-24-37.5-56.7-37.5-90.7c0-27.7 9-54.8 25.6-76.9z"/></svg>
                            </div>
                        </div>
                        <div class="content">
                            <span class="value value--xsmall">N/A</span>
                            <span class="label">UV Index</span>
                        </div>
                    </div>

                    <div class="row col--span-3">
                        <div class="item">
                            <div class="meta"></div>
                            <div class="icon">
                                <div class="weather-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 64c-26.5 0-48 21.5-48 48l0 164.5c0 17.3-7.1 31.9-15.3 42.5C86.2 332.6 80 349.5 80 368c0 44.2 35.8 80 80 80s80-35.8 80-80c0-18.5-6.2-35.4-16.7-48.9c-8.2-10.6-15.3-25.2-15.3-42.5L208 112c0-26.5-21.5-48-48-48zM48 112C48 50.2 98.1 0 160 0s112 50.1 112 112l0 164.4c0 .1 .1 .3 .2 .6c.2 .6 .8 1.6 1.7 2.8c18.9 24.4 30.1 55 30.1 88.1c0 79.5-64.5 144-144 144S16 447.5 16 368c0-33.2 11.2-63.8 30.1-88.1c.9-1.2 1.5-2.2 1.7-2.8c.1-.3 .2-.5 .2-.6L48 112zM208 368c0 26.5-21.5 48-48 48s-48-21.5-48-48c0-20.9 13.4-38.7 32-45.3L144 208c0-8.8 7.2-16 16-16s16 7.2 16 16l0 114.7c18.6 6.6 32 24.4 32 45.3z"/></svg>
                                </div>
                            </div>
                            <div class="row">
                                <div class="content w--20">
                                    <span class="value value--small">{{ $tomorrowMin ? round($tomorrowMin, 1) : 'N/A' }}°</span>
                                    <span class="label">Low</span>
                                </div>
                                <div class="content w--20">
                                    <span class="value value--small">{{ $tomorrowMax ? round($tomorrowMax, 1) : 'N/A' }}°</span>
                                    <span class="label">High</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="title_bar">
        <img class="image" src="https://usetrmnl.com/images/plugins/weather--render.svg" />
        <h1 class="title">Weather</h1>
        <span class="instance">{{ now()->format('Y-m-d H:i') }}</span>
    </div>
</div>
