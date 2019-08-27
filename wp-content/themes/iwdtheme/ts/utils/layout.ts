import { assert } from "chai";

declare const $: any;

const $window = $(window);

const horizProperty = "left";

function windowWidth()
{
	return $window.outerWidth();
}

function getLeftOverspill($e)
{
	return -$e.offset().left;
}

function getRightOverspill($e)
{
	const width = $e.outerWidth();
	const left = $e.offset().left;
	const right = width + left;

	return right - windowWidth();
}

export function fixHorizOverspill($e): void
{
	if ($e.length === 0)
	{
		console.warn("fixHorizOverspill passed $e element with length 0");
		return;
	}

	$e.css(horizProperty, "");

	const leftOverspill = getLeftOverspill($e);
	const rightOverspill = getRightOverspill($e);

	if (leftOverspill > 0)
	{
		$e.css(horizProperty, `+=${leftOverspill}`);
	}
	else if (rightOverspill > 0)
	{
		$e.css(horizProperty, `-=${rightOverspill}`);
	}
}
