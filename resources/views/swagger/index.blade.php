<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List API - Documentation</title>
    <link rel="stylesheet" href="{{asset('swagger/swagger-ui.css')}}">
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="{{asset('swagger/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('swagger/swagger-ui-bundle.js')}}"></script>
    <script type="application/javascript">
        const ui = SwaggerUIBundle({
            url: "{{ asset('swagger/swagger.json') }}",
            dom_id: '#swagger-ui',
        });
    </script>
</body>
</html>
