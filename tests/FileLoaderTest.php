<?php

use Mayoturis\Properties\FileLoader;
use Mayoturis\Properties\VariableProcessor;

class FileLoaderTest extends PHPUnit_Framework_TestCase {

	public function test_getArrayFromLines() {
		$fileLoader = new FileLoader(new VariableProcessor());

		$array = $fileLoader->getArrayFromLines($this->getLines());
		$expectedArray = [$this->getExpectedArray(), $this->getExpectedMap()];

		$this->assertEquals($expectedArray, $array);
	}

	public function test_processValue() {
		$fileLoader = new FileLoader(new VariableProcessor());

		$this->assertEquals('string', $fileLoader->processValue('"string"'));
		$this->assertEquals('string', $fileLoader->processValue('\'string\''));
		$this->assertEquals(5, $fileLoader->processValue('5'));
		$this->assertEquals(5.1, $fileLoader->processValue('5.1'));
		$this->assertEquals(null, $fileLoader->processValue('null'));
		$this->assertEquals(true, $fileLoader->processValue('true'));
		$this->assertEquals(false, $fileLoader->processValue('false'));
	}

	protected function getLines() {
		return [
			"value1=text",
			"value2=\"text2\"",
			"",
			"value3='text3'",
			"value4=1",
			"value5=1.5",
			"value6=true",
			"value7=false",
			"value8=null",
			"// comment",
			"; comment",
			"# comment",
		];
	}

	protected function getExpectedArray() {
		return [
			"value1" => "text",
			"value2" => "text2",
			"value3" => "text3",
			"value4" => 1,
			"value5" => 1.5,
			"value6" => true,
			"value7" => false,
			"value8" => null,
		];
	}

	protected function getExpectedMap() {
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