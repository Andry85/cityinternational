<?php
namespace IllicitWeb;

class MailSignupPrinter extends Printer
{
	const PRINTER_CLASS = 'IllicitWeb\MailChimpForm\SimpleFormPrinter';

	private $display = false;
	private $title;
	private $backgroundImage;
	private $formPrinter;

	public function __construct()
	{
		if (!get_field('display_mail_signup'))
		{
			return;
		}

		if (!$this->printerClassExists())
		{
			return;
		}

		$this->display = true;
		$this->formPrinter = $this->createPrinter();
		$this->title = get_field('mail_signup_heading');
		$this->backgroundImage = get_field('mail_signup_background_image');
	}

	private function printerClassExists()
	{
		return class_exists(self::PRINTER_CLASS);
	}

	private function createPrinter()
	{
		$class = self::PRINTER_CLASS;
		return new $class();
	}

	public function printHtml()
	{
		if (!$this->display)
		{
			return;
		}

		?>
		<section class="content-block mail-signup"<?php 
			if ($this->backgroundImage): 
				?> style="background-image: url('<?=
					$this->backgroundImage['url'] ?>'); "<?php
			endif ?>>
			<div class="dark-overlay"></div>
			<div class="content-block-inner">
				<div>
					<?php if ($this->title): ?>
					<h2><?= $this->title ?></h2>
					<?php endif ?>

					<div class="mail-signup-form">
						<?= $this->formPrinter ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
