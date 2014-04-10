<!doctype html>
<html lang="lv">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
</head>
<body>
    <header>
        <nav>
            <div {{ (Request::is('/') ? 'class="active"' : '') }}>
                <a href="{{{ URL::to('') }}}">Home</a>
            
            </div>
        </nav>
    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        
    </footer>
</body>
</html>
