<!DOCTYPE html>
<html>
<head>
	<title>Send-email</title>
	<link rel="stylesheet" href="/css/app.css">
</head>
<body>

	<div id="app">
		<sendmail></sendmail>
	</div>

	
	<script>
		window.Laravel = <?php echo json_encode([
		  'csrfToken' => csrf_token(),
		]); ?>
    </script>
	<script src="/js/app.js"></script>
</body>
</html>