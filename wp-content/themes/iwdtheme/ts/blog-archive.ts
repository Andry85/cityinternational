import { assert } from "chai";

declare const $: any;

export function init(): void
{
	$(".monthly-archive").each(function each() {
		const $wrap = $(this);
		const $limited = $wrap.find(".archive-limited");
		const $all = $wrap.find(".archive-all");

		if (!thereIsOverspill($limited, $all))
		{
			return;
		}

		const $showWrap = $wrap.find(".archive-show-all");
		const $hide = $wrap.find("[data-action=\"hide\"]");
		const $show = $wrap.find("[data-action=\"show\"]");

		$showWrap.css({ display: "" });

		$hide.on("click", e => {
			$limited.show();
			$all.hide();
			return false;
		});

		$show.on("click", e => {
			$limited.hide();
			$all.show();
			return false;
		});
	});
}

function thereIsOverspill($limited: any, $all: any): boolean
{
	const limitedCount = $limited.find("ul.top-level-archive-list > li").length;
	const allCount = $all.find("ul.top-level-archive-list > li").length;

	return limitedCount < allCount;
}
