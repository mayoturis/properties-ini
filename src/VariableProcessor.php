<?php  namespace Mayoturis\Properties; 

class VariableProcessor {
	/**
	 * Removes ' or " from string
	 *
	 * @param string $value
	 * @return string
	 */
	public function getString($value) {
		if ($this->startsWith($value, '\'') && $this->endsWith($value, '\'')) {
			return ltrim(rtrim($value, '\''), '\'');
		}
		if ($this->startsWith($value, '"') && $this->endsWith($value, '"')) {
			return ltrim(rtrim($value, '"'), '"');
		}

		return $value;
	}

	/**
	 * True if $value is null string
	 *
	 * @param string $value
	 * @return bool
	 */
	public function isNull($value) {
		return $value == 'null';
	}

	/**
	 * True if $value is number string
	 *
	 * @param string $value
	 * @return bool
	 */
	public function isNumber($value) {
		return is_numeric($value);
	}

	/**
	 * Returns number from string
	 *
	 * @param string $value
	 * @return number
	 */
	public function getNumber($value) {
		return $value + 0;
	}

	/**
	 * Returns bool from string
	 *
	 * @param string $value
	 * @return bool
	 */
	public function getBool($value) {
		return $value == 'true';
	}

	/**
	 * True if $value is boolean string
	 *
	 * @param string $value
	 * @return bool
	 */
	public function isBool($value) {
		return $value == 'true' || $value == 'false';
	}

	/**
	 * True if $line is without characters
	 *
	 * @param string $line
	 * @return bool
	 */
	public function isEmptyLine($line) {
		$line = trim($line);
		return empty($line);
	}

	public function isCommentLine($line) {
		return $this->startsWith($line, ';') ||
		$this->startsWith($line, '//') ||
		$this->startsWith($line, '#');
	}

	/**
	 * True if $haystack starts with needle
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	/**
	 * True if $haystack ends with $needle
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	public function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

	/**
	 * Creates string from bool
	 *
	 * @param bool $value
	 * @return string
	 */
	public function boolToString($value) {
		 return $value == true ? 'true' : 'false';
	}
}