<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="max-w-xl text-white bg-gray-900 p-8 w-full">
        <img src="{{ $image }}" alt="">
        <h1 class="text-5xl mt-12">{{ $title }}</h1>
        <p class="mt-4 text-xl">{{ $description }}</p>
    </div>
</body>

</html>