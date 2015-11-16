<?php  namespace Mayoturis\Properties; 

class RepositoryFactory {

	/**
	 * Create repository instance
	 *
	 * @param string $filePath File where configuration is stored
	 * @return Repository
	 */
	public static function make($filePath) {
		$variableProcessor = new VariableProcessor();

		$fileSaver = new FileSaver($variableProcessor);
		$fileLoader = new FileLoader($variableProcessor);

		return new Repository($fileLoader, $fileSaver, $filePath);
	}
}