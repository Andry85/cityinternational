import { map, max } from "lodash";

declare const $: any;

const $window = $(window);

const wait = 4000;

const transition = 2000;

export function init(): void
{
	$(".latest-news-strip").each(function each() {
		const $outer = $(this);
		const $inner = $outer.children();
		const $sections = $outer.find(".latest-news-strip-post");

		setupHeightCorrection($sections, $inner);

		beginCycle($sections, 0);
	})	
}

function setupHeightCorrection($sections: any, $inner: any): void
{
	function setHeight()
	{
		$sections.height("");

		const height = getTallestHeight($sections);

		$inner.height(height);

		$sections.height(height);
	}

	setHeight();

	$window.on("resize", setHeight);
}

function getTallestHeight($sections: any): number
{
	return max(map($sections.toArray(), section => $(section).outerHeight()));
}

function beginCycle($sections: any, currentIndex: number): void
{
	const $expired = $sections.eq(currentIndex);

	const nextIndex = (currentIndex + 1 >= $sections.length) ? 0 : currentIndex + 1;

	const $next = $sections.eq(nextIndex);

	$sections.stop(true);

	setTimeout(() => {
		$expired.css({ zIndex: 0 }).animate({ opacity: 0 }, transition);
		
		$next.css({ zIndex: 1 }).animate(
			{ opacity: 1 }, 
			transition, 
			() => beginCycle($sections, nextIndex));
	}, wait);
}
