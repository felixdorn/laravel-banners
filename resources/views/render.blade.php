<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        * {
            font-family: "Nunito", sans-serif;
        }
    </style>
</head>
<body class="p-6 flex items-center justify-center">
<div class="h-full bg-white p-16 rounded-lg flex justify-between flex-col">
    <img src="{{ $image }}" alt="" class="w-16 h-16">
    <h1 class="font-bold text-indigo-600 mt-8" style="font-size: 60px;">{{ $title }}</h1>
    <p class="text-2xl text-gray-600 mt-8" style="line-height: 36px">{{ $body }}</p>
</div>

</body>

</html>
