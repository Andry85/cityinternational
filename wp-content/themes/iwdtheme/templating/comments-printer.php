<?php

namespace IllicitWeb;

class CommentsPrinter extends SectionPrinter
{
	public function printHtml()
	{
		if (!post_password_required()) {
			comments_template('', true);
		}
	}
}
