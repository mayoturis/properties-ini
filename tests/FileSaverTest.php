<?php

use Mayoturis\Properties\FileSaver;
use Mayoturis\Properties\VariableProcessor;

class FileSaverTest extends PHPUnit_Framework_TestCase {
	public function test_createOutputWithMap() {
		$saver = new FileSaver(new VariableProcessor());

		$expectedString = $this->getExpectedStringWithMap();
		$string = $saver->createOutputWithMap($this->getArray(), $this->getMap());

		$this->assertEquals($expectedString, $string);
	}

	public function test_createOutput() {
		$saver = new FileSaver(new VariableProcessor());

		$expectedString = $this->getExpectedStringWithoutMap();
		$string = $saver->createOutput($this->getArray(), $this->getMap());

		$this->assertEquals($expectedString, $string);
	}

	protected function getExpectedStringWithMap() {
		return
			"value1=text" . PHP_EOL .
			"value2=\"text2\"" . PHP_EOL .
			"" . PHP_EOL .
			"value3='text3'" . PHP_EOL .
			"value4=1" . PHP_EOL .
			"value5=1.5" . PHP_EOL .
			"value6=true" . PHP_EOL .
			"value7=false" . PHP_EOL .
			"value8=null" . PHP_EOL .
			"// comment" . PHP_EOL .
			"; comment" . PHP_EOL .
			"# comment" . PHP_EOL .
			"notmappedvalue=\"value\"" . PHP_EOL;

	}

	protected function getExpectedStringWithoutMap() {
		return
			"value1=\"text\"" . PHP_EOL .
			"value2=\"text2\"" . PHP_EOL .
			"value3=\"text3\"" . PHP_EOL .
			"value4=1" . PHP_EOL .
			"value5=1.5" . PHP_EOL .
			"value6=true" . PHP_EOL .
			"value7=false" . PHP_EOL .
			"value8=null" . PHP_EOL .
			"notmappedvalue=\"value\"" . PHP_EOL;
	}

	protected function getArray() {
		return [
			"value1" => "text",
			"value2" => "text2",
			"value3" => "text3",
			"value4" => 1,
			"value5" => 1.5,
			"value6" => true,
			"value7" => false,
			"value8" => null,
			"notmappedvalue" => 'value',
		];
	}

	protected function getMap() {
		return [
			1 => ['type' => 'value', 'key' => 'value1', 'info' => null],
			2 => ['type' => 'value', 'key' => 'value2', 'info' => ['around' => '"']],
			3 => ['type' => 'empty'],
			4 => ['type' => 'value', 'key' => 'value3', 'info' => ['around' => '\'']],
			5 => ['type' => 'value', 'key' => 'value4', 'info' => null],
			6 => ['type' => 'value', 'key' => 'value5', 'info' => null],
			7 => ['type' => 'value', 'key' => 'value6', 'info' => null],
			8 => ['type' => 'value', 'key' => 'value7', 'info' => null],
			9 => ['type' => 'value', 'key' => 'value8', 'info' => null],
			10 => ['type' => 'comment', 'value' => '// comment'],
			11 => ['type' => 'comment', 'value' => '; comment'],
			12 => ['type' => 'comment', 'value' => '# comment'],
		];
	}
}