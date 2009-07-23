<?php
/*****************************************************************************
 * SV-Cart CSS
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: css.php 727 2009-04-17 08:00:49Z huangbo $
*****************************************************************************/
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found');
}

if (!class_exists('File')) {
	uses('file');
}
	function make_clean_css($path, $name) {
		require(VENDORS . 'csspp' . DS . 'csspp.php');
		$data = file_get_contents($path);
		$csspp = new csspp();
		$output = $csspp->compress($data);
		$ratio = 100 - (round(strlen($output) / strlen($data), 3) * 100);
		$output = " /* file: $name, ratio: $ratio% */ " . $output;
		return $output;
	}

	function write_css_cache($path, $content) {
		if (!is_dir(dirname($path))) {
			mkdir(dirname($path));
		}
		$cache = new File($path);
		return $cache->write($content);
	}

	if (preg_match('|\.\.|', $url) || !preg_match('|^ccss/(.+)$|i', $url, $regs)) {
		die('Wrong file name.');
	}

	$filename = 'css/' . $regs[1];
	$filepath = CSS . $regs[1];
	$cachepath = CACHE . 'css' . DS . str_replace(array('/','\\'), '-', $regs[1]);

	if (!file_exists($filepath)) {
		die('Wrong file name.');
	}

	if (file_exists($cachepath)) {
		$templateModified = filemtime($filepath);
		$cacheModified = filemtime($cachepath);

		if ($templateModified > $cacheModified) {
			$output = make_clean_css($filepath, $filename);
			write_css_cache($cachepath, $output);
		} else {
			$output = file_get_contents($cachepath);
		}
	} else {
		$output = make_clean_css($filepath, $filename);
		write_css_cache($cachepath, $output);
		$templateModified = time();
	}

	header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
	header("Content-Type: text/css");
	header("Expires: " . gmdate("D, j M Y H:i:s", time() + DAY) . " GMT");
	header("Cache-Control: cache"); // HTTP/1.1
	header("Pragma: cache");        // HTTP/1.0
	print $output;
?>