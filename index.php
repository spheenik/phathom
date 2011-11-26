<?php 
	session_start();
	if (!isset($_SESSION["chosen"])) {
		$_SESSION["examples"] = array(
			"Calculator" => "examples/calculator/calculator.php",
			"CSS Spec Reader" => "examples/css_spec/css_spec.php",
		);
		$_SESSION["chosen"] = current($_SESSION["examples"]);
	}
?>
<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	</head>
	<body>
		<form>
			Choose example: 
			<select onchange="$('#frame').attr('src', $(this).val());">
				<?php foreach ($_SESSION["examples"] as $name => $url): ?>
					<option value="<?php echo $url; ?>"><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
		</form>
		<hr/>
		<iframe id="frame" style="border:0" src="<?php echo $_SESSION["chosen"]; ?>"></iframe>
		<script>
			function resize() {
				var f = $('#frame');
				f.height(f.contents().height());
				f.width(f.contents().width());
				setTimeout(resize, 200);
			}
			setTimeout(resize, 200);
		</script>
		
	</body>
</html>
