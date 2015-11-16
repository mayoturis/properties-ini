<?php  namespace Mayoturis\Properties;

class FileSaver implements FileSaverInterface{

	/**
	 * VariableProcessor
	 */
	private $processor;

	/**
	 * @param VariablProcessor $processor
	 */
	public function __construct(VariableProcessor $processor) {
		$this->processor = $processor;
	}

	/**
	 * Writes configuration array to file
	 *
	 * @param string $fileName File name
	 * @param array $values Configuration values
	 * @param array|null $map File map
	 */
	public function save($fileName, $values, $map = null) {
		if ($map !== null) {
			$output = $this->createOutputWithMap($values,$map);
		} else {
			$output = $this->createOutput($values);
		}

		$this->saveToFile($fileName, $output);
	}

	/**
	 * Creates output string with provided map
	 *
	 * @param array $values Configuration values
	 * @param array $map
	 * @return string
	 */
	public function createOutputWithMap(array $values, array $map) {
		$output = '';
		foreach ($map as $outputLine) {
			if ($outputLine['type'] == 'empty') {
				$output .= PHP_EOL;
			} elseif($outputLine['type'] == 'comment') {
				$output .= $outputLine['value'] . PHP_EOL;
			} else {
				$output .= $this->createLine($outputLine['key'], $values[$outputLine['key']], $outputLine) . PHP_EOL;
				unset($values[$outputLine['key']]);
			}
		}

		// Add values which are not mapped at the end
		$output .= $this->createOutput($values);

		return $output;
	}

	/**
	 * Creates output string from configuration values
	 *
	 * @param array $values Configuration values
	 * @return string
	 */
	public function createOutput($values) {
		$output = '';
		foreach ($values as $key => $value) {
			$output .= $this->createLine($key, $value) . PHP_EOL;
		}

		return $output;
	}

	/**
	 * Creates string from $key and $value
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param array|null $outputLineMap
	 * @return string
	 */
	protected function createLine($key, $value, $outputLineMap = null) {
		return $key .= '=' . $this->createValue($value, $outputLineMap);
	}

	/**
	 * Creates string from $value.
	 * $outputLineMap can help to create the value
	 *
	 * @param mixed $value
	 * @param array|null $outputLineMap
	 * @return string
	 */
	protected function createValue($value, $outputLineMap = null) {
		if (is_bool($value)) {
			return $this->processor->boolToString($value);
		}

		if (is_numeric($value)) {
			return $value . '';
		}

		if ($value == null) {
			return 'null';
		}

		if (isset($outputLineMap['info']['around'])) {
			return $outputLineMap['info']['around'] . $value . $outputLineMap['info']['around'];
		}

		if ($outputLineMap === null) {
			return '"' . $value . '"';
		}

		return $value;
	}


	/**
	 * Save $output to $fileName
	 *
	 * @param string $fileName
	 * @param string $output
	 */
	protected function saveToFile($fileName, $output) {
		file_put_contents($fileName, $output);
	}

}