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
<body>
<div style="border-width: 22px" class="border-indigo-600 h-screen p-24 flex justify-between flex-col">
    <img src="{{ $image }}" alt="" class="w-32 h-32">
    <div>

        <h1 class="font-bold text-indigo-600" style="font-size: 120px;">{{ $title }}</h1>
        <p class="text-6xl text-gray-600 mt-16" style="line-height: 82px">{{ $body }}</p>
    </div>
</div>

</body>

</html>
