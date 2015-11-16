<?php  namespace Mayoturis\Properties;

interface RepositoryInterface {
	/**
	 * Set a given configuration value
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value);

	/**
	 * Return configuration value
	 *
	 * @param string $key
	 * @param string|null $default
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Get all configuration values
	 *
	 * @return array
	 */
	public function all();

	/**
	 * Change all configuration values
	 *
	 * @param array $array Associative array with key and value
	 * @return void
	 */
	public function setAll($array);
}