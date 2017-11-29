<?php
namespace Sellastica\UI\Presenter;

interface IPresenter extends \Nette\Application\IPresenter
{
	/**
	 * @return string
	 */
	function getShortName(): string;
}
