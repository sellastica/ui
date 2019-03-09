<?php
namespace Sellastica\UI\Form;

use Sellastica\Communication\IResponse;

/**
 * @method \Sellastica\PrettyForms\PrettyCheckbox addPrettyCheckbox($name, $caption = null)
 * @method \Sellastica\PrettyForms\PrettyCheckboxList addPrettyCheckboxList($name, $label = null, array $items = null)
 * @method \Sellastica\PrettyForms\PrettyRadioList addPrettyRadioList($name, $label = null, array $items = null)
 * @method \Sellastica\PrettyForms\BootstrapRadioList addBootstrapRadioList($name, $label = null, array $items = null)
 * @method \Nette\Forms\Container|Form addContainer($name)
 * @method \Sellastica\PrettyForms\BootstrapCheckbox addBootstrapCheckbox($name, $caption = null)
 */
class Form extends \Nette\Application\UI\Form
{
	const FIELD_REQUIRED = 'required',
		FIELD_OPTIONAL = 'optional',
		FIELD_HIDDEN = 'hidden';

	/** @var array */
	private $errors;


	/**
	 * @param mixed $error
	 * @param bool $translate
	 * @throws \InvalidArgumentException
	 */
	public function addError($error, $translate = true)
	{
		if ($translate && $this->getTranslator()) {
			$error = $this->getTranslator()->translate($error);
		}

		$this->errors[] = $error;
	}

	/**
	 * @param IResponse $response
	 */
	public function addResponseErrors(IResponse $response)
	{
		foreach ($response->getErrors() as $error) {
			$this->addError($error);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}