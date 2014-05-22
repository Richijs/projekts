<!doctype html>
<html lang="{{ Config::get('app.locale') }}">
<head>
	<meta charset="UTF-8">
	<title>404</title>
</head>
<body>
    <div class="page-header">
        <h1>404 {{ trans('content.error') }}</h1>
        <div>
            {{ trans('content.not-found') }}
        </div>
    </div>
</body>
</html>