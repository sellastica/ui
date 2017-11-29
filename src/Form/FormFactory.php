<?php
namespace Sellastica\UI\Form;

use Nette;
use Nette\Forms\Controls\SelectBox;
use Nette\Forms\Validator;
use Nette\Localization\ITranslator;

class FormFactory
{
	/** @var Nette\Security\User */
	protected $user;
	/** @var ITranslator */
	protected $translator;
	/** @var Nette\Http\Request */
	protected $request;


	/**
	 * @param ITranslator $translator
	 * @param Nette\Security\User $user
	 * @param Nette\Http\Request $request
	 * @internal param Translator $translator
	 */
	public function __construct(
		ITranslator $translator,
		Nette\Security\User $user,
		Nette\Http\Request $request
	)
	{
		$this->translator = $translator;
		$this->user = $user;
		$this->setDefaultFormMessages();
		$this->request = $request;
	}

	/**
	 * @return Form
	 */
	public function create(): Form
	{
		return $this->doCreate();
	}

	/**
	 * @return Form
	 */
	public function createWithActionFromRequest(): Form
	{
		return $this->doCreate(
			$this->request->getUrl()->setQueryParameter(Nette\Application\UI\Presenter::FLASH_KEY, null)
		);
	}

	/**
	 * @param Nette\Http\Url|null $url
	 * @return Form
	 */
	private function doCreate(Nette\Http\Url $url = null)
	{
		$form = new Form();
		$form->setTranslator($this->translator);
		if (isset($url)) {
			$form->setAction('/' . $url->getRelativeUrl());
		}

		if ($this->user->isLoggedIn()) {
			$form->addProtection();
		}

		return $form;
	}

	private function setDefaultFormMessages()
	{
		Validator::$messages = array_merge(
			Validator::$messages,
			[
				Form::EMAIL => $this->translator->translate('system.forms.default_form_messages.invalid_email_format'),
				Form::FILLED => $this->translator->translate('system.forms.default_form_messages.cannot_be_blank'),
				Form::FLOAT => $this->translator->translate('system.forms.default_form_messages.integers_or_floats_only'),
				Form::INTEGER => $this->translator->translate('system.forms.default_form_messages.integers_only'),
				Form::MIN_LENGTH => $this->translator->translate('system.forms.default_form_messages.minimal_length'),
				Form::MAX_LENGTH => $this->translator->translate('system.forms.default_form_messages.maximal_length'),
				Form::NUMERIC => $this->translator->translate('system.forms.default_form_messages.integers_only'),
				Form::PATTERN => $this->translator->translate('system.forms.default_form_messages.invalid_pattern'),
				Form::RANGE => $this->translator->translate('system.forms.default_form_messages.not_in_valid_range'),
				Form::URL => $this->translator->translate('system.forms.default_form_messages.invalid_url_format'),
				SelectBox::VALID => $this->translator->translate('system.forms.default_form_messages.choose_some_option'),
			]
		);
	}
}