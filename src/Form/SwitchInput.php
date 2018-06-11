<?php
namespace Sellastica\UI\Form;

class SwitchInput
{
	/** @var string */
	private $name;
	/** @var string */
	private $id;
	/** @var string|null */
	private $label = null;
	/** @var bool */
	private $checked = false;
	/** @var array */
	private $attributes = [];


	/**
	 * @param string $name
	 * @param string $id
	 */
	public function __construct(string $name, string $id)
	{
		$this->name = $name;
		$this->id = $id;
	}

	/**
	 * @return null|string
	 */
	public function getLabel(): ?string
	{
		return $this->label;
	}

	/**
	 * @param null|string $label
	 * @return SwitchInput
	 */
	public function setLabel(?string $label): SwitchInput
	{
		$this->label = $label;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isChecked(): bool
	{
		return $this->checked;
	}

	/**
	 * @param bool $checked
	 * @return SwitchInput
	 */
	public function setChecked(bool $checked): SwitchInput
	{
		$this->checked = $checked;
		return $this;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return SwitchInput
	 */
	public function addAttribute(string $name, $value = null): SwitchInput
	{
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * @return \Nette\Utils\Html
	 */
	public function toHtml(): \Nette\Utils\Html
	{
		//input
		$input = \Nette\Utils\Html::el('input')
			->name($this->name)
			->type('checkbox')
			->id($this->id)
			->class('switch-input');

		foreach ($this->attributes as $attribute => $value) {
			$input->$attribute = $value;
		}


		if ($this->checked) {
			$input->setAttribute('checked', 'checked');
		}

		//label
		$label = \Nette\Utils\Html::el('label')
			->for($this->id)
			->class('switch-paddle');

		$el = \Nette\Utils\Html::el('span')->class('switch');
		$el->addHtml($input);
		$el->addHtml($label);

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