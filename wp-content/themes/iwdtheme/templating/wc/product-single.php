<?php
namespace IllicitWeb;

class ProductSinglePrinter extends SectionPrinter
{
    private $product; // Product|null

    public function __construct()
    {
        $this->product = Product::fromCurrent();
    }

    public function printHtml()
    {
        if (!$this->product)
        {
            return;
        }

		$this->printOpen();
		$this->printPreSummary();
		$this->printSummary();
		$this->printClose();
    }

	private function printOpen()
	{
		?>
		<div class="content-block product-single-main">
			<div class="content-block-inner">
				<div itemscope itemtype="<?= woocommerce_get_product_schema()
					?>" id="product-<?= $this->product->id() ?>">
		<?php
	}

	private function printClose()
	{
		?>
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
		<?php
	}

	private function printPreSummary()
	{
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	}

	private function printSummary()
	{
		$product = $this->product;
		$title = $product->title();
		$unit_price = format_money($product->unitPrice(), '&pound;');
		$description = $product->content();

		?>
		<div class="product-summary">

			<h1><?= $title ?></h1>

			<div class="price">
				<?= $unit_price ?>
			</div>

			<div class="description">
				<?= $description ?>
			</div>

			<?php woocommerce_template_single_add_to_cart() ?>
		</div>
		<?php
	}
}
