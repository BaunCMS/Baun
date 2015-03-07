<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Baun Auto Installer</title>
	<link rel="stylesheet" href="/auto-install.css">
</head>
<body>
	<?php
	echo 'Baun Auto Installer<br>';
	echo '-------------------<br><br>';
	try {
		$output = [];

		if (!file_exists(BASE_PATH . 'composer.phar')) {
			echo 'Attempting to download composer...<br>';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://getcomposer.org/installer');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);
			if ($data === false) {
				die($error);
			}

			file_put_contents(BASE_PATH . 'composer.phar', $data);

			echo 'Attempting to install composer...<br>';
			$result = shell_exec('cd ' . escapeshellcmd(BASE_PATH) . ' && php composer.phar install');
			$output = array_merge($output, explode("\n", $result));
		}

		echo 'Attempting to install composer packages...<br>';
		$result = shell_exec('cd ' . escapeshellcmd(BASE_PATH) . ' && php composer.phar update');
		$output = array_merge($output, explode("\n", $result));

		echo '<ul>';
		if (!empty($output)) {
			foreach ($output as $item) {
				if ($item) {
					echo '<li>' . $item . '</li>';
				}
			}
		}
		echo '</ul><br>';

		echo '<a href="/">Finished installing. Lets go &rarr;</a><br>';
	} catch(Exception $e) {
		echo '<span class="error">Auto install failed (missing vendor/autoload.php). Run <code>composer install</code> manually.</span>';
	}
	?>
</body>
</html>