<?php
namespace Sellastica\UI\Presentation;

use Sellastica\Twig\Exception\ObjectNotExistException;
use Sellastica\Twig\Model\ProxyObject;

/**
 * {@inheritdoc}
 * @property \Sellastica\UI\Pagination\Pagination $parent
 */
class PaginationProxy extends ProxyObject
{
	/**
	 * @param int $itemsPerPage
	 */
	public function setItemsPerPage($itemsPerPage)
	{
		$this->parent->setItemsPerPage($itemsPerPage);
	}

	/**
	 * @return int|NULL
	 * @throws ObjectNotExistException
	 */
	public function getItems()
	{
		return $this->parent->getItemCount();
	}

	/**
	 * @return int
	 * @throws ObjectNotExistException
	 */
	public function getFirst_item_on_page()
	{
		return $this->parent->getFirstItemNumber();
	}

	/**
	 * @return int
	 * @throws ObjectNotExistException
	 */
	public function getLast_item_on_page()
	{
		return $this->parent->getLastItemNumber();
	}

	/**
	 * @return int|NULL
	 * @throws ObjectNotExistException
	 */
	public function getPages()
	{
		return $this->parent->getPageCount();
	}

	/**
	 * @return FALSE|int
	 * @throws ObjectNotExistException
	 */
	public function getPrevious_page()
	{
		return $this->parent->getPreviousPage();
	}

	/**
	 * @return FALSE|int
	 * @throws ObjectNotExistException
	 */
	public function getNext_page()
	{
		return $this->parent->getNextPage();
	}

	/**
	 * @return int
	 * @throws ObjectNotExistException
	 */
	public function getCurrent_page()
	{
		return $this->parent->getPage();
	}

	/**
	 * @param int $range
	 * @return array
	 */
	public function getRange($range = \Sellastica\UI\Pagination\Pagination::DEFAULT_RANGE_SIZE)
	{
		if (!is_int($range)) {
			$range = \Sellastica\UI\Pagination\Pagination::DEFAULT_RANGE_SIZE;
		}

		return $this->parent->getRange($range);
	}

	/**
	 * @param int $page
	 * @return string
	 */
	public function getLink_to_page($page)
	{
		return $this->parent->getUrl($page);
	}

	/**
	 * @param int $range
	 * @return string
	 */
	public function getAsString($range = \Sellastica\UI\Pagination\Pagination::DEFAULT_RANGE_SIZE)
	{
		return $this->parent->getAsString($range);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->parent->getAsString();
	}

	/**
	 * @return string
	 */
	public function getShortName()
	{
		return 'pagination';
	}

	/**
	 * @return array
	 */
	public function getAllowedProperties()
	{
		return [
			'items',
			'first_item_on_page',
			'last_item_on_page',
			'pages',
			'previous_page',
			'next_page',
			'current_page',
			'link_to_page',
			'range',
		];
	}
}