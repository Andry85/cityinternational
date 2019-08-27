import { assert } from "chai";

import { registerScrollDetectEvent } from "./scroll-detect";

declare const $: any;

const $body = $("body");

const className = "scrolled";

function addClass()
{
	$body.addClass(className);
}

function removeClass()
{
	$body.removeClass(className);
}

export function init()
{
	registerScrollDetectEvent(addClass, removeClass);
}
