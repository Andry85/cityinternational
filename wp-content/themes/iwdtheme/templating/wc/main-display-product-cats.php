<?php
namespace IllicitWeb;

class MainDisplayProductCatsPrinter extends SectionPrinter
{
    private $cats; // MainDisplayProductCats

    private $heading = 'Categories';

    public function __construct()
    {
        $this->cats = new MainDisplayProductCats();
    }

    public function printHtml()
    {
        if ($this->cats->isEmpty())
        {
            return;
        }

        ?>
        <div class="content-block wc-thumbs-content-block">
            <div class="content-block-inner">
                <?php if ($this->heading): ?>
				<h2><?= $this->heading ?></h2>
				<?php endif ?>
                <ul class="wc-thumb-items">
                    <?php $this->printCats() ?>
                </ul>
            </div>
        </div>
        <?php
    }

    private function printCats()
    {
        $this->cats->forEachTerm(function (ProductCategory $product_cat) {

            $image = $product_cat->thumbnail();
            $url = $product_cat->link();
            $name = $product_cat->name();
            $description = strip_tags($product_cat->description());

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
                        <div class="wc-thumb-item-link-description">
                            <?= $description ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php
        });
    }
}
