<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $post->title }}</title>
    </head>

    <body style="
        margin:0;
        padding:40px 15px;
        background-color:#f3f4f6;
        font-family:Arial, Helvetica, sans-serif;
    ">
        <h1>
            {{ $post->title }}
        </h1>
        <p>
            {!! $post->content !!}
        </p>
    </body>
</html>