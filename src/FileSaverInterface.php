<?php  namespace Mayoturis\Properties;

interface FileSaverInterface {
	public function save($fileName, $array, $map = null);
}