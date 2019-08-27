<?php
namespace IllicitWeb;

class MainDisplayProductsPrinter extends SectionPrinter
{
    private $products; // MainDisplayProducts
    
    public function __construct()
    {
        $this->products = new MainDisplayProducts();
    }
    
    public function printHtml()
    {
        if ($this->products->isEmpty())
        {
            return;
        }
        
        ?>
        <div class="content-block wc-thumbs-content-block">
            <div class="content-block-inner">

				<h2><?= $this->products->getProductCategoryName() ?></h2>

                <ul class="wc-thumb-items">
                    <?php $this->printProducts() ?>
                </ul>
            </div>
        </div>
        <?php
    }
    
    private function printProducts()
    {
        $this->products->forEachProduct(function (Product $product) {
            
            $image = $product->image();
            $url = $product->link();
            $name = $product->title();
            
            ?>
            <li class="wc-thumb-item">
                <?php if ($image): ?>
                <div class="wc-thumb-item-bgd" style="background-image:url('<?=
                    $image['url'] ?>');"></div>
                <?php endif ?>
                
                <a class="wc-thumb-item-link" href="<?= $url ?>">
                    <div class="wc-thumb-item-link-text">
                        <div class="wc-thumb-item-link-name">
                            <?= $name ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php
        });
    }
}
