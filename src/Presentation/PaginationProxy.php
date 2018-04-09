<?php
namespace Sellastica\UI\Presentation;

use Sellastica\Twig\Model\ProxyObject;

/**
 * {@inheritdoc}
 * @property \Sellastica\UI\Pagination\Pagination $parent
 */
class PaginationProxy extends ProxyObject
{
	/**
	 * @return int|null
	 */
	public function getItems(): ?int
	{
		return $this->parent->getItemCount();
	}

	/**
	 * @return int
	 */
	public function getFirst_item_on_page(): int
	{
		return $this->parent->getFirstItemNumber();
	}

	/**
	 * @return int
	 */
	public function getLast_item_on_page(): int
	{
		return $this->parent->getLastItemNumber();
	}

	/**
	 * @return int|null
	 */
	public function getPages(): ?int
	{
		return $this->parent->getPageCount();
	}

	/**
	 * @return int|null
	 */
	public function getPrevious_page(): ?int
	{
		return $this->parent->getPreviousPage();
	}

	/**
	 * @return int|null
	 */
	public function getNext_page(): ?int
	{
		return $this->parent->getNextPage();
	}

	/**
	 * @return int
	 */
	public function getCurrent_page(): int
	{
		return $this->parent->getPage();
	}

	/**
	 * @param int $range
	 * @return array
	 */
	public function getRange($range = \Sellastica\UI\Pagination\Pagination::DEFAULT_RANGE_SIZE): array
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
	public function getLink_to_page($page): string
	{
		return $this->parent->getUrl($page);
	}

	/**
	 * @param int $range
	 * @return string
	 */
	public function getAsString($range = \Sellastica\UI\Pagination\Pagination::DEFAULT_RANGE_SIZE): string
	{
		return $this->parent->getAsString($range);
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->parent->getAsString();
	}

	/**
	 * @return string
	 */
	public function getShortName(): string
	{
		return 'pagination';
	}

	/**
	 * @return array
	 */
	public function getAllowedProperties(): array
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