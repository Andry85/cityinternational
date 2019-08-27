// Dependency: jQuery scrollTo plugin

import { registerScrollDetectEvent } from "./scroll-detect";

declare const $: any;

const revealedClassName = "revealed";

const triggerScrollAt = 500; // px scrolled

function getTriggerScrollAt()
{
	return triggerScrollAt;
}

export function init(): void
{
	const scrollToSettings = {
		axis: "y",
		duration: 400,
		onAfter: hide
	};

	const $btn = $("<span class=\"back-to-top-btn\" title=\"Back to top\">");

	function show(): void
	{
		$btn.addClass(revealedClassName);
	}

	function hide(): void
	{
		$btn.removeClass(revealedClassName);
	}

	function scroll(): void
	{
		$.scrollTo(0, scrollToSettings);
	}

	$btn.on("click", scroll).appendTo("body");

	registerScrollDetectEvent(show, hide, getTriggerScrollAt);
}
