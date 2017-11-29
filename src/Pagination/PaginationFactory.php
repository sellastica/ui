<?php
namespace Sellastica\UI\Pagination;

use Nette;

class PaginationFactory
{
	/** @var int */
	private $page;
	/** @var Nette\Http\IRequest */
	private $request;

	
	/**
	 * @param Nette\Http\IRequest $request
	 */
	public function __construct(Nette\Http\IRequest $request)
	{
		$this->request = $request;
		$this->page = $this->request->getUrl()->getQueryParameter('page', 1);
	}

	/**
	 * @param int $itemsPerPage
	 * @param int $limit
	 * @return Pagination
	 */
	public function create($itemsPerPage = null, $limit = Pagination::RESULTS_LIMIT)
	{
		$itemsPerPage = min(abs((int) $itemsPerPage), $limit) ?: $limit;
		$pagination = new Pagination($this->request, $itemsPerPage);
		$pagination->setPage($this->page);

		return $pagination;
	}
}