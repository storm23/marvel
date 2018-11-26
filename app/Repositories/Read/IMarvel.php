<?php
namespace Stormz23\Marvel\Repositories\Read;

interface IMarvel {

	public function getAllCharacters($offset, $limit);
	public function getAllSeries($offset, $limit );
	public function getSerieCharacters($marvelId, $offset, $limit);
}
