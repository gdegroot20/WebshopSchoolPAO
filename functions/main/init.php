<?php
function init($dir) {

	if (file_exists($dir)) {

		$files = scandir($dir);
		foreach ($files as $file) {

			if (!is_dir($file)) {
				if (substr($file, -4) == '.ini') {

					$ini_array = parse_ini_file($dir . DIRECTORY_SEPARATOR . $file);
					foreach ($ini_array as $key => $value) {
						$key = trim($key);
						$value = trim($value);

						$key = strtoupper($key);

						define($key, $value);
					}

				} elseif (!($file == '.' || $file == '..')) {
					init($dir . DIRECTORY_SEPARATOR . $file);
				}
			}

		}

	}

}
?>