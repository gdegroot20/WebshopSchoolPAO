<?php

function bootstrap($dir) {
	if (file_exists($dir)) {
		$files = scandir($dir);
		foreach ($files as $file) {
			if (!is_dir($file)) {

				if (substr($file, -4) == '.php') {
					require_once $dir . DIRECTORY_SEPARATOR . $file;
				} else {
					if (!($file == '.' || $file == '..')) {
						bootstrap($dir . DIRECTORY_SEPARATOR . $file);
					}
				}
			}
		}
	}
}

?>