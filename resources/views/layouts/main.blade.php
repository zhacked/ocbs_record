
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

	<title>{{ config('', 'Kiosk SOA') }}</title>
	<link rel="shortcut icon" href="{{ asset('image/icons8-calculator-48.png') }}">
   
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper" id="app">

        @include('layouts.components.navbar')

        @include('layouts.components.sidebar')

        @include('layouts.components.content')

        @include('layouts.components.footer')
    </div>

@auth
    <script type="text/javascript">
        window.user = @json(auth()->user())
    </script>
@endauth

    <script src="/js/app.js"></script>
    	


</body>
</html>
