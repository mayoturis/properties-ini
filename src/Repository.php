<?php  namespace Mayoturis\Properties;

class Repository implements RepositoryInterface{

	/**
	 *	ArrayLoader
	 */
	private $loader;
	/**
	 * array $array Loaded values
	 */
	private $array;
	/**
	 * array $fileMap File map with comments and empty lines
	 */
	private $fileMap;
	/**
	 * FileSaverInterface $saver
	 */
	private $saver;
	/**
	 * string $fileName
	 */
	private $fileName;

	/**
	 * @param FileLoaderInterface $loader
	 * @param FileSaverInterface $saver
	 * @param string $fileName
	 */
	public function __construct(FileLoaderInterface $loader, FileSaverInterface $saver, $fileName) {
		$this->loader = $loader;
		$this->saver = $saver;
		$this->fileName = $fileName;
	}

	/**
	 * Set a given configuration value and save file
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value) {
		$this->loadIfNeeded();

		$this->array[$key] = $value;

		$this->saver->save($this->fileName, $this->array, $this->fileMap);
	}

	/**
	 * Change all configuration values and save file
	 *
	 * @param array $array Associative array with key and value
	 * @return void
	 */
	public function setAll($array) {
		$this->array = $array;
		$this->fileMap = null;

		$this->saver->save($this->fileName, $this->array, $this->fileMap);
	}

	/**
	 * Return configuration value
	 *
	 * @param string $key
	 * @param string|null $default
	 * @return mixed
	 */
	public function get($key, $default = null) {
		$this->loadIfNeeded();

		return isset($this->array[$key]) ? $this->array[$key] : $default;
	}

	/**
	 * Get all configuration values
	 *
	 * @return array
	 */
	public function all() {
		$this->loadIfNeeded();

		return $this->array;
	}

	protected function loadIfNeeded() {
		if (empty($this->array)) {
			list($this->array, $this->fileMap) = $this->loader->load($this->fileName);
		}
	}
}