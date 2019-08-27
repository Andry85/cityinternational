import { assert } from "chai";

import { registerScrollDetectEvent } from "./scroll-detect";

const offset = 350;

const revealedClassName = "revealed";

declare const $: any;

export function init(): void
{
	$(".secondary-content-anim").each(function eachWrap() {
		initWrap($(this));
	});

	$(".content-anim").each(function eachWrap() {
		initWrap($(this));
	});

	$(".big-link").each(function eachWrap() {
		initWrap($(this));
	});
}

function initWrap($wrap: any): void 
{
	registerScrollDetectEvent(
		() => show($wrap),
		() => hide($wrap),
		() => getThreshold($wrap)
	);
}

function getViewportHeight(): number
{
	return window.innerHeight;
}

function getTop($e: any): number
{
	return $e.offset().top;
}

function getThreshold($wrap: any): number
{
	return getTop($wrap) + -getViewportHeight() + offset;
}

function show($wrap): void
{
	$wrap.addClass(revealedClassName);
}

function hide($wrap): void
{
	$wrap.removeClass(revealedClassName);
}
