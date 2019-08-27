<?php

namespace IllicitWeb;

class SocialFeedsPrinter extends SectionPrinter
{
	public function printHtml()
	{
		$tweets = get_latest_tweets();

		$twitter_screenname = get_twitter_screenname_as_link();

		$fbpost = get_latest_facebook_post();
		
		?>
		<section class="content-block social-feeds">
			<div class="content-block-inner">
				<div class="social-feed-twitter">
					<h2>Latest From Twitter</h2>
					<?php foreach ($tweets as $tweet): ?>
					<h3><?= $twitter_screenname ?> &middot; <?=
						date('d M', $tweet['timestamp']) ?></h3>
					<div class="tweet">
						<?= $tweet['html'] ?>
					</div>
					<?php endforeach ?>
				</div>
				<div class="social-feed-facebook">
					<h2>Latest From Facebook</h2>
					<?php if ($fbpost): ?>
					<?= $fbpost->message ?>
					<?php endif ?>
				</div>
			</div>
		</section>
		<?php
	}
}
