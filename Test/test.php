<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>PHPShortener Test</title>
		
		<style type="text/css" media="screen">
			.pass { background: green; }
			.nopass { background: red; }
		</style>
	</head>
</html>
<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once(dirname(__FILE__) . '/../Source/phpshortener.class.php');

$s = new PHPShortener();

function row($url, $service, $should_be, $is){
	$class = (($should_be === true && strstr($is, $service)) || $should_be === $is) ? 'pass' : 'nopass';
	if ($should_be === true) $should_be = 'http://' . rtrim($service, '/') . '/[something]';
	echo "<tr class='$class'>";
		echo "<td>$url</td><td>$service</td><td>$should_be</td><td>$is</td>";
	echo '</tr>';
	flush();
}

?>
<h1>PHPShortener Test Page</h1>

<h2>Encoding</h2>
<table>
	<thead>
		<th>Long URL</th>
		<th>Service</th>		
		<th>Should be</th>
		<th>Response</th>
	</thead>
	<tbody>
		<?php row('http://google.com', 'is.gd', 'http://is.gd/w', $s->encode('http://google.com', 'is.gd')) ?>
		<?php row('http://google.com', 'bit.ly', 'http://bit.ly/11etr', $s->encode('http://google.com', 'bit.ly')) ?>		
		<?php row('http://google.com', 'tinyurl.com', 'http://tinyurl.com/2x6rgl', $s->encode('http://google.com', 'tinyurl.com')) ?>
		<?php row('http://google.com', 'tr.im', true, $s->encode('http://google.com', 'tr.im')) ?>		
		<?php row('http://google.com', 'twurl.nl', true, $s->encode('http://google.com', 'twurl.nl')) ?>				
	</tbody>
</table>

<p><em>[something]</em> indicates the response varies, so we can't test against a fixed value.</p>

<h2>Decoding</h2>
<table>
	<thead>
		<th>Short URL</th>
		<th>Service</th>		
		<th>Should be</th>
		<th>Response</th>
	</thead>
	<tbody>
		<?php row('http://is.gd/w', 'is.gd', 'http://google.com', $s->decode('http://is.gd/w')) ?>
		<?php row('http://bit.ly/11etr', 'bit.ly', 'http://google.com', $s->decode('http://bit.ly/GH4Cn')) ?>		
		<?php row('http://tinyurl.com/2x6rgl', 'tinyurl.com', 'http://google.com', $s->decode('http://tinyurl.com/2x6rgl')) ?>
		<?php row('http://tr.im/jBte', 'tr.im', 'http://google.com/', $s->decode('http://tr.im/jBte')) ?>		
		<?php row('http://twurl.nl/ubxmn0', 'twurl.nl', 'http://google.com', $s->decode('http://twurl.nl/ubxmn0')) ?>		
				
		<?php row('is.gd/w', 'is.gd', 'http://google.com', $s->decode('is.gd/w')) ?>
		<?php row('bit.ly/GH4Cn', 'bit.ly', 'http://google.com', $s->decode('bit.ly/GH4Cn')) ?>		
		<?php row('tinyurl.com/2x6rgl', 'tinyurl.com', 'http://google.com', $s->decode('tinyurl.com/2x6rgl')) ?>
		<?php row('tr.im/jBte', 'tr.im', 'http://google.com/', $s->decode('tr.im/jBte')) ?>		
		<?php row('twurl.nl/ubxmn0', 'twurl.nl', 'http://google.com', $s->decode('twurl.nl/ubxmn0')) ?>				
		
		<?php row('www.tinyurl.com/2x6rgl', 'tinyurl.com', 'http://google.com', $s->decode('tinyurl.com/2x6rgl')) ?>		
	</tbody>
</table>

<h1>Copyright</h1>
<p><strong>Guillermo Rauch</strong> &mdash; <a href="http://devthought.com">Devthought</a> &copy; <?php echo date('Y') ?></p>