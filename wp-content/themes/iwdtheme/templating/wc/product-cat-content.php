<?php
namespace IllicitWeb;

class ProductCatContentPrinter extends SectionPrinter
{
    private $productCat; // ProductCat|null
    private $heading;
    private $body;
    private $linkUrl;
    private $linkText;

    // $fallback is a product category (or id, or slug) which is used in the
    // case where $product_cat is set to null AND there is no current product
    // cat. Both args can be null, slug, id or ProductCategory instance.
    public function __construct($product_cat=null, $fallback=null)
    {
    	$this->setCurrentProductCategory($product_cat, $fallback);

        if ($this->productCat)
        {
	       	$this->heading = $this->productCat->acfTrim('product_cat_ct_heading');
			$this->body = $this->productCat->acfTrim('product_cat_ct_body');
			$this->linkUrl = $this->productCat->acfTrim('product_cat_ct_btn_link');
			$this->linkText = $this->productCat->acfTrim('product_cat_ct_btn_text');
        }
    }

    private function setCurrentProductCategory($product_cat, $fallback)
    {
        if ($product_cat)
        {
            $this->productCat = resolve_product_cat_arg($product_cat);
        }
        else
        {
            $this->productCat = ProductCategory::fromCurrent();
     
            if (!$this->productCat)
            {
                $this->productCat = resolve_product_cat_arg($fallback);
            }
        }
    }

    public function printHtml()
    {
        if ($this->shouldPrint())
        {
            $this->printOpen();
			$this->printMain();
			$this->printClose();
        }
    }

    private function shouldPrint()
    {
    	return $this->productCat && ($this->body || $this->linkUrl);
    }

	private function printOpen()
	{
		?>
		<section class="content-block product-cat-content">
		<?php
	}

	private function printMain()
	{
		?>

		<?php if ($this->heading): ?>
		<header class="content-block-inner">
			<h2><?= $this->heading ?></h2>
		</header>
		<?php endif ?>

		<div class="content-block-inner">

			<?php if ($this->body): ?>
			<div class="product-cat-content-body">
				<?= $this->body ?>
			</div>
			<?php endif ?>

			<?php if ($this->linkUrl): ?>
			<div class="product-cat-content-link-wrap">
				<a class="button" href="<?= $this->linkUrl ?>"><?= $this->linkText ?></a>
			</div>
			<?php endif ?>
		
		</div>
		<?php
	}

	private function printClose()
	{
		?>
		</section>
		<?php
	}
}


function product_cat_content($product_cat=null, $fallback=null)
{
	echo new ProductCatContentPrinter($product_cat, $fallback);
}
