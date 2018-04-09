<?php
namespace Sellastica\UI\Pagination;

use Nette;
use Nette\Utils\Html;
use Nette\Utils\Paginator;
use Sellastica\Twig\Model\IProxable;
use Sellastica\Twig\Model\ProxyConverter;
use Sellastica\UI\Presentation\PaginationProxy;

class Pagination extends Paginator implements IProxable
{
	const DEFAULT_PAGINATION = 25;
	/** Number of pages have to be displayed before and after current page */
	const DEFAULT_RANGE_SIZE = 3;
	/** Result fetch limit */
	const RESULTS_LIMIT = 100;
	/** @var Nette\Http\IRequest */
	private $request;


	/**
	 * @param Nette\Http\IRequest $request
	 * @param int $itemsPerPage
	 */
	public function __construct(Nette\Http\IRequest $request, $itemsPerPage = null)
	{
		$this->request = $request;
		$this->setItemsPerPage(is_int($itemsPerPage) && $itemsPerPage > 0 ? $itemsPerPage : self::DEFAULT_PAGINATION);
	}

	/**
	 * @return int|null
	 */
	public function getPreviousPage(): ?int
	{
		return !$this->isFirst() ? $this->getPage() - 1 : null;
	}

	/**
	 * @return int|null
	 */
	public function getNextPage(): ?int
	{
		return !$this->isLast() ? $this->getPage() + 1 : null;
	}

	/**
	 * @return int
	 */
	public function getFirstItemNumber(): int
	{
		return ($this->getPage() - 1) * $this->getItemsPerPage() + 1;
	}

	/**
	 * @return int
	 */
	public function getLastItemNumber(): int
	{
		return min($this->getPage() * $this->getItemsPerPage(), $this->getItemCount());
	}

	/**
	 * @param int $rangeSize
	 * @return array
	 */
	public function getRange($rangeSize = self::DEFAULT_RANGE_SIZE): array
	{
		$range = range(max($this->getPage() - $rangeSize, 1), min($this->getPage() + $rangeSize, $this->getPageCount()));
		if ($range[0] === 3) {
			//to avoid 1...3,4
			array_unshift($range, 2);
		}

		if ($range[sizeof($range) - 1] === $this->getPageCount() - 2) {
			//to avoid e.g. 15,16,...,18 if 18 is the last page
			$range[] = $this->getPageCount() - 1;
		}

		return $range;
	}

	/**
	 * @param $page
	 * @return string
	 */
	public function getUrl($page): string
	{
		$url = $this->request->getUrl();
		$url->setQueryParameter('page', (int)$page > 1 ? (int)$page : null);
		return $url->getAbsoluteUrl();
	}

	/**
	 * @param int $range
	 * @return string
	 */
	public function getAsString($range = self::DEFAULT_RANGE_SIZE): string
	{
		if ($this->getPageCount() > 1) {
			$ul = Html::el('ul')->class('pagination');
			$range = $this->getRange($range);

			//previous page
			if ($this->getPreviousPage()) {
				$a = Html::el('a')->href($this->getUrl($this->getPreviousPage()))->setHtml('&laquo;');
				$ul->addHtml(Html::el('li')->addHtml($a));
			}

			//first page
			if ($range[0] > 1) {
				$a = Html::el('a')->href($this->getUrl(1))->setText(1);
				$ul->addHtml(Html::el('li')->addHtml($a));
			}

			//...
			if ($range[0] > 2) {
				$ul->addHtml(Html::el('li')->setHtml('&hellip;'));
			}

			//pages
			foreach ($range as $i) {
				$a = Html::el('a')->href($this->getUrl($i))->setText($i);
				if ($this->getPage() === $i) {
					$a->class('current');
				}

				$ul->addHtml(Html::el('li')->addHtml($a));
			}

			//...
			if ($range[sizeof($range) - 1] < $this->getPageCount() - 1) {
				$ul->addHtml(Html::el('li')->setHtml('&hellip;'));
			}

			//last page
			if ($range[sizeof($range) - 1] < $this->getPageCount()) {
				$a = Html::el('a')->href($this->getUrl($this->getPageCount()))->setText($this->getPageCount());
				$ul->addHtml(Html::el('li')->addHtml($a));
			}

			//next page
			if ($this->getNextPage()) {
				$a = Html::el('a')->href($this->getUrl($this->getNextPage()))->setHtml('&raquo;');
				$ul->addHtml(Html::el('li')->addHtml($a));
			}

			return (string)$ul;
		}

		return '';
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->getAsString();
	}

	/**
	 * @return PaginationProxy
	 */
	public function toProxy(): PaginationProxy
	{
		return ProxyConverter::convert($this, PaginationProxy::class);
	}
}