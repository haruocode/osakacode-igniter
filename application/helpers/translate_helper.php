<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('trans')) {
	/**
	 * @author someone
	 * @param $id : to get index of array language data
	 * @param array $parameters_array :
	 * @param null $language
	 * @return string
	 * @TODO write trans function with accept parameters array
	 */
	function trans($id, $parameters_array = array(), $language = null)
	{
		$array_index = explode('.', $id);
		$lang_filename = $array_index[0];
		$line = $array_index[1];
		$result_text = '';
		$CI = get_instance();
		$CI->lang->load($lang_filename, $language);
		$array_text = $CI->lang->line($line);
		//if not found translate
		if(!$array_text) {
			return $id;
		}
		if (!is_array($array_text)) {
			return $array_text;
		}
		array_splice($array_index, 0, 2);

		foreach ($array_index as $index) {
			$result_text = isset($array_text[$index]) ? $array_text[$index] : $result_text;
			//gán lại array text để lọc tiếp cho vòng lặp tiếp theo
			$array_text = $result_text;
		}
		//parse param to text
		foreach ($parameters_array as $param=>$value) {
			$result_text = str_replace('{$' . $param . '}', $value, $result_text);
		}
		return $result_text ? $result_text : $id;
	}
}