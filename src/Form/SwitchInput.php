<?php
namespace Sellastica\UI\Form;

class SwitchInput
{
	/** @var string */
	private $name;
	/** @var string */
	private $id;
	/** @var \Nette\Utils\Html */
	private $input;
	/** @var \Nette\Utils\Html */
	private $label;


	/**
	 * @param string $name
	 * @param string $id
	 */
	public function __construct(string $name, string $id)
	{
		$this->name = $name;
		$this->id = $id;

		//input
		$this->input = \Nette\Utils\Html::el('input')
			->name($this->name)
			->type('checkbox')
			->id($this->id)
			->class('switch-input js-switch js-switch-1');

		//label
		$this->label = \Nette\Utils\Html::el('label')
			->for($this->id)
			->class('switch-paddle');
	}

	/**
	 * @param bool $checked
	 * @return SwitchInput
	 */
	public function setChecked(bool $checked): SwitchInput
	{
		if ($checked)  {
			$this->input->setAttribute('checked', 'checked');
		} else {
			$this->input->removeAttribute('checked');
		}

		return $this;
	}

	/**
	 * @return \Nette\Utils\Html
	 */
	public function getInput(): \Nette\Utils\Html
	{
		return $this->input;
	}

	/**
	 * @return \Nette\Utils\Html
	 */
	public function getLabel(): \Nette\Utils\Html
	{
		return $this->label;
	}

	/**
	 * @return \Nette\Utils\Html
	 */
	public function toHtml(): \Nette\Utils\Html
	{
		$el = \Nette\Utils\Html::el('span')->class('switch js-switch js-switch-1');
		$el->addHtml($this->input);
		$el->addHtml($this->label);

		return $el;
	}

	/**
	 * @return string
	 */
	public function render(): string
	{
		return (string)$this->toHtml();
	}

	/**
	 * @param string $name
	 * @param string $id
	 * @return SwitchInput
	 */
	public static function create(string $name, string $id): SwitchInput
	{
		return new self($name, $id);
	}
}