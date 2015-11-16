<?php namespace Mayoturis\Properties;

class FileLoader implements FileLoaderInterface {

	/**
	 *
	 */
	private $processor;

	/**
	 * @param VariablProcessor $processor
	 */
	public function __construct(VariableProcessor $processor) {
		$this->processor = $processor;
	}

	/**
	 * Returns array which consists of value array and map
	 *
	 * @param string $fileName
	 * @return array
	 * @throws \Exception
	 */
	public function load($fileName) {
		if (!file_exists($fileName)) {
			throw new \InvalidArgumentException('File ' . $fileName . ' does not exist');
		}

		$lines = $this->readLinesFromFile($fileName);

		return $this->getArrayFromLines($lines);
	}

	/**
	 * Creates value and map array from string lines
	 *
	 * @param array $lines
	 * @return array
	 * @throws InvalidLineException
	 */
	public function getArrayFromLines(array $lines) {
		$array = [];
		$map = [];

		$i = 1;
		foreach ($lines as $line) {
			if ($this->processor->isEmptyLine($line)) {
				$map[$i] = ['type' => 'empty'];
			} elseif ($this->processor->isCommentLine($line)) {
				$map[$i] = ['type' => 'comment', 'value' => $line];
			} else {
				$keyValue = explode('=', $line, 2);
				if (count($keyValue) < 2) {
					throw new InvalidLineException('Invalid line in configuration file');
				}
				list($key, $value) = $keyValue;

				$key = trim($key);

				$array[$key] = $this->processValue($value);
				$map[$i] = ['type' => 'value', 'key' => $key];
				$map[$i]['info'] = $this->mapInfoForValue($value);
			}

			$i++;
		}

		return [$array,$map];
	}

	/**
	 * Creates value from string
	 *
	 * @param string $value
	 * @return bool|number|null|string
	 */
	public function processValue($value) {
		$value = ltrim(rtrim($value));

		if ($this->processor->isBool($value)) {
			return $this->processor->getBool($value);
		}

		if ($this->processor->isNumber($value)) {
			return $this->processor->getNumber($value);
		}

		if ($this->processor->isNull($value)) {
			return null;
		}

		return $this->processor->getString($value);
	}



	/**
	 * Return array of lines from file
	 *
	 * @param string $filePath
	 * @return array
	 */
	protected function readLinesFromFile($filePath)
	{
		// Read file into an array of lines with auto-detected line endings
		$autodetect = ini_get('auto_detect_line_endings');
		ini_set('auto_detect_line_endings', '1');
		$lines = file($filePath, FILE_IGNORE_NEW_LINES);
		ini_set('auto_detect_line_endings', $autodetect);
		return $lines;
	}

	/**
	 * Return info for $value
	 *
	 * @param string $value
	 * @return array
	 */
	protected function mapInfoForValue($value) {
		if ($this->processor->startsWith($value, '\'') && $this->processor->endsWith($value, '\'')) {
			return ['around' => '\''];
		}

		if ($this->processor->startsWith($value, '"') && $this->processor->endsWith($value, '"')) {
			return ['around' => '"'];
		}
	}
}