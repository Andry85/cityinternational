<?php
namespace IllicitWeb;

class RelatedProductsPrinter extends SectionPrinter
{
	private $products = null; // Product array or null

    const DF_LIMIT = 3;

    const DF_HEADING = 'Related Products';

    public function __construct($heading=null, $limit=null)
    {
        $product = Product::fromCurrent();

        if (!$product)
        {
        	return;
        }
    
    	if ($limit === null)
    	{
    		$limit = self::DF_LIMIT;
    	}

    	$this->heading = ($heading === null) ? 
    		self::DF_HEADING : 
    		trim($heading);

        $this->products = $product->getRelatedProducts($limit);
    }

    public function printHtml()
    {
        if (!$this->products)
        {
            return;
        }

		$this->printOpen();
		$this->printHeader();
		$this->printMain();
		$this->printClose();
    }

	private function printOpen()
	{
		?>
		<section class="content-block related-products">
		<?php
	}

	private function printHeader()
	{
		if (!$this->heading)
		{
			return;
		}

		?>
		<header class="content-block-inner">
			<h2><?= $this->heading ?></h2>
		</header>
		<?php
	}

	private function printMain()
	{
		?>
		<div class="content-block-inner">
			<ul>
				<?php foreach ($this->products as $product): ?>
					<?php $this->printProduct($product) ?>
				<?php endforeach ?>
			</ul>
		</div>
		<?php
	}

	private function printProduct(Product $product) 
	{
		$title = $product->title();
		$url = $product->link();
		$image = $product->image();

		?>
		<li>
			<div>
				<?php /* @todo */ ?>
			</div>
		</li>
		<?php
	}
	
	private function printClose()
	{
		?></section><?php
	}
}
