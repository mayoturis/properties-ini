<?php

class RepositoryTest extends PHPUnit_Framework_TestCase {
	public function test_get_should_load_file_once_and_get_correct_value() {
		$loader = $this->createLoaderMock();
		$saver = $this->createSaverMock();
		$repository = new \Mayoturis\Properties\Repository($loader, $saver, 'file_name');
		$exampleConfig = $this->getExampleConfiguration();
		$loader->shouldReceive('load')->once()->with('file_name')->andReturn([$exampleConfig,'map']);

		$name = $repository->get('name');
		$male = $repository->get('male');
		$notExisting = $repository->get('not_existing');

		$this->assertEquals($name, $exampleConfig['name']);
		$this->assertEquals($male, $exampleConfig['male']);
		$this->assertNull($notExisting);
	}

	public function test_all_should_load_file_once_and_get_all() {
		$loader = $this->createLoaderMock();
		$saver = $this->createSaverMock();
		$repository = new \Mayoturis\Properties\Repository($loader, $saver, 'file_name');
		$exampleConfig = $this->getExampleConfiguration();
		$loader->shouldReceive('load')->once()->with('file_name')->andReturn([$exampleConfig,'map']);

		$all = $repository->all();

		$this->assertEquals($all, $exampleConfig);
	}

	public function test_test_should_set_value_and_save() {
		$loader = $this->createLoaderMock();
		$saver = $this->createSaverMock();
		$repository = new \Mayoturis\Properties\Repository($loader, $saver, 'file_name');
		$exampleConfig = $this->getExampleConfiguration();
		$loader->shouldReceive('load')->once()->with('file_name')->andReturn([$exampleConfig,'map']);
		$saver->shouldReceive('save');
		$exampleConfig['job'] = 'designer';
		$exampleConfig['newKey'] = 'newValue';

		$repository->set('job', 'designer');
		$repository->set('newKey', 'newValue');

		$this->assertEquals($repository->all(), $exampleConfig);
	}

	public function test_setAll_sets_all_values_deteles_map_and_saves() {
		$loader = $this->createLoaderMock();
		$saver = $this->createSaverMock();
		$repository = new \Mayoturis\Properties\Repository($loader, $saver, 'file_name');
		$exampleConfig = $this->getExampleConfiguration();
		$saver->shouldReceive('save')->once()->with('file_name', $exampleConfig, null);

		$repository->setAll($exampleConfig);

		$this->assertEquals($exampleConfig, $repository->all());
	}

	public function createLoaderMock() {
		return Mockery::mock('Mayoturis\\Properties\\FileLoader');
	}

	public function createSaverMock() {
		return Mockery::mock('Mayoturis\\Properties\\FileSaver');
	}

	public function getExampleConfiguration() {
		return [
			"name" => "Marek",
			"job" => "programmer",
			"male" => true
		];
	}
}