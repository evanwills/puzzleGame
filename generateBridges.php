<?php

// ==================================================================
// START: debug include

if(!function_exists('debug'))
{
	if(isset($_SERVER['HTTP_HOST'])){ $path = $_SERVER['HTTP_HOST']; $pwd = dirname($_SERVER['SCRIPT_FILENAME']).'/'; }
	else { $path = $_SERVER['USER']; $pwd = $_SERVER['PWD'].'/'; };
	if( substr_compare( $path , '192.168.' , 0 , 8 ) == 0 ) { $path = 'localhost'; }
	switch($path)
	{
		case '192.168.18.128':	// work laptop (debian)
		case 'antechinus':	// work laptop (debian)
		case 'localhost':	// home laptop
		case 'evan':		// home laptop
		case 'wombat':	$root = '/var/www/';	$inc = $root.'includes/'; $classes = $cls = $root.'classes/'; break; // home laptop

		case 'burrawangcoop.net.au':	// DreamHost
		case 'adra.net.au':		// DreamHost
		case 'canc.org.au':		// DreamHost
		case 'ewills':	$root = '/home/ewills/evan/'; $inc = $root.'includes/'; $classes = $cls = $root.'classes/'; break; // DreamHost

		case 'apps.acu.edu.au':		// ACU
		case 'testapps.acu.edu.au':	// ACU
		case 'dev1.acu.edu.au':		// ACU
		case 'blogs.acu.edu.au':	// ACU
		case 'studentblogs.acu.edu.au':	// ACU
		case 'dev-blogs.acu.edu.au':	// ACU
		case 'evanw':	$root = '/home/evanw/';	$inc = $root.'includes/'; $classes = $cls = $root.'classes/'; break; // ACU

		case 'webapps.acu.edu.au':	   // ACU
		case 'panvpuwebapps01.acu.edu.au': // ACU
		case 'test-webapps.acu.edu.au':	   // ACU
		case 'panvtuwebapps01.acu.edu.au': // ACU
		case 'dev-webapps.acu.edu.au':	   // ACU
		case 'panvduwebapps01.acu.edu.au': // ACU
		case 'evwills':
			if( isset($_SERVER['HOSTNAME']) && $_SERVER['HOSTNAME'] = 'panvtuwebapps01.acu.edu.au' ) {
				$root = '/home/evwills/'; $inc = $root.'includes/'; $classes = $cls = $root.'classes/'; break; // ACU
			} else {
				$root = '/var/www/html/mini-apps/'; $inc = $root.'includes_ev/'; $classes = $cls = $root.'classes_ev/'; break; // ACU
			}
	};

	set_include_path( get_include_path().PATH_SEPARATOR.$inc.PATH_SEPARATOR.$cls.PATH_SEPARATOR.$pwd);

	if(file_exists($inc.'debug.inc.php'))
	{
		if(!file_exists($pwd.'debug.info') && is_writable($pwd) && file_exists($inc.'template.debug.info'))
		{ copy( $inc.'template.debug.info' , $pwd.'debug.info' ); };
		include($inc.'debug.inc.php');
	}
	else { function debug(){}; };

	class emergency_log { public function write( $msg , $level = 0 , $die = false ){ echo $msg; if( $die === true ) { exit; } } }
};

// END: debug include
// ==================================================================

require_once('/var/www/html//play/binary/binary.class.php');


$bits = '';

function rotateBits($input) {
	$input = str_split($input);
	$old = array_pop($input);
	array_unshift($input,$old);
	$output = '';
	for( $a = 0 ; $a < count($input) ; $a += 1 ) {
		$output .= "{$input[$a]}";
	}
	return $output;
}

$unique = array();



function generateBits( $bitLen ) {
	if( !is_int($bitLen) || $bitLen < 3 || $bitLen > 10 ) {
		if( !is_int($bitLen) ) {
			$suffix = gettype($bitLen);
		} else {
			$suffix = $bitLen;
		}
		die('generateBits() expects first param $depth to be a an integer greater than 2 and less than 11. '.$suffix.' given');
	}

	$binary = new stuff_with_binaries($bitLen);

	$unique = array();
	$max = pow(2,$bitLen);
//	$bitLen *= 2;
	for( $a = 0 ; $a < $max ; $a += 1 ) {
		$bin = $tmp = $binary->integer_to_binary($a);
		for( $b = 0 ; $b < $bitLen ; $b += 1 ) {
			if( isset($unique[$tmp]) ) {
				continue 2;
			}
			$tmp = rotateBits($tmp);
		}
		$tmp = strrev($bin);
		for( $b = 0 ; $b < $bitLen ; $b += 1 ) {
			if( isset($unique[$tmp]) ) {
				$unique[$tmp] = true;
				continue 2;
			}
			$tmp = rotateBits($tmp);
		}
		$unique[$bin] = false;
	}
	//debug(count($unique));
	$output = array();
	foreach($unique as $bridges => $mirrorable ) {
		$bridgeCount = substr_count($bridges,'1');
/*
		if( $mirrorable === true ) {
			$mirrorable = 'true';
		} else {
			$mirrorable = 'false';
		}
*/
		$tmp = array( 'bridgeCount' => $bridgeCount , 'code' => '' , 'bridges' => $bridges , 'mirrorable' => $mirrorable );
		if( !isset($output[$bridgeCount]) ) {
			$output[$bridgeCount] = array();
		}
		$output[$bridgeCount][] = $tmp;
	}
	foreach($output as $bridgeCount => $patterns) {
		$c = count($patterns);
		if( $c > 1) {
			$A = 'a';
			for( $a = 0 ; $a < $c ; $a += 1 ) {
				$patterns[$a]['code'] = $A;
				$A++;
			}
			$output[$bridgeCount] = $patterns;
		}
	}
	$php = "<?php\n\nclass bridges$bitLen {\n\n\tprivate \$uniquePatterns = ".count($unique).";\n\n\tprivate \$patterns = ".preg_replace(
		array(
			'`\[([0-9]+)\]`',	// 0
			'`\[([a-z]+)\]`i',	// 1
			'`\s+\(`',			// 2
			'`\t{2}`',			// 3
			'`("mirrorable" => )1`',	// 4
			'`("mirrorable" => )(?=\s+)`',	// 5
			'`("(?:bridgeCount|key|bridges)".*?)(?=[\r\n])`',	// 6
			'`Array \(`',		// 7
			'`("key" => )([a-z]?)(?=,[\r\n])`',	// 8
			'`([01]{4,8})`'		// 9
		),
		array(
			'\1',		// 0
			'"\1"',		// 1
			' (',		// 2
			"\t",		// 3
			'\1true',	// 4
			'\1false',	// 5
			'\1,',		// 6
			'array(',	// 7
			'\1"\2"',	// 8
			'"\1"'		// 9
		),
		print_r($output,true)
	).";\n}\n";
	//echo $php;
	debug($output);

	$json = "\nvar bridgePatterns = [";
	$php = "\n\tprivate \$bridgePatterns = array(";
	$sep = '';
	foreach($output as $bridgeCount => $patterns) {
		for( $a = 0 ; $a < count($patterns) ; $a += 1 ) {
			$json .= "$sep\n\t\t{";
			$json .= "$sep\n\t\tarray(";
			$innerSep = '';
			foreach($patterns[$a] as $key => $value ) {
				if( is_bool($value) ) {
					if( $value === true ) {
						$value = ' true';
					} else {
						$value = 'false';
					}
				} else {
					if( $value === '' ) {
						$value = ' ""';
					} else {
						$value = '"'.$value.'"';
					}
				}
				$json .= "$innerSep \"$key\": $value";
				if( !is_numeric($key) ) {
					$key = "'$key'";
				}
				$php .= "$innerSep $key => $value";
				$innerSep = ',';
			}
		$sep = ',';
		$json .= " }";
		$json .= " )";
		}
	}
	$json .= "\n\t]\n";
	return $json;
}

//debug(generateBits(8));
generateBits(8);
//debug(generateBits(6));
generateBits(6);
//debug(generateBits(4));
generateBits(4);
