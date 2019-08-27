import { assert } from "chai";

declare const $: any;

const linkSelector = "a[href^=\"#\"]:not([href=\"#\"])";

const scrollToConfig = {
	duration: 500,
	axis: "y"
};

export function init()
{
	$(linkSelector).each(function eachLink() {
		const $link = $(this);
		const href = $link.attr("href");
		const $target = $(href);

		$link.on("click", e => {
			$.scrollTo($target, scrollToConfig);
			e.preventDefault();
		});
	});
}
