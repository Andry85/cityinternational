import { assert } from "chai";

declare const $: any;

const $window = $(window);

export function parallaxRefresh(): void
{
	$window.trigger("resize.px.parallax");
}
