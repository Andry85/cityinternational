import "hammerjs";

declare const $: any;
declare const Hammer: any;

export function init(): void
{
	$(".slides").each(function () {
		initSlidesWrap($(this));
	});
}

function initSlidesWrap($wrap: any): void
{
	const $inner = $wrap.find(".slides-wrap").children();
	const $prev = $wrap.find("[data-slide-nav='prev']");
	const $next = $wrap.find("[data-slide-nav='next']");
	const numSlides = $wrap.find(".slide").length;
	const finalIndex = numSlides - 1;
	const autoslideWait = parseInt($wrap.attr("data-autoslide"), 10) || undefined;
	const slideDurationEstimate = 1000;

	if (finalIndex < 0)
	{
		return;
	}

	let index = 0;

	function getTranslateValue(): string
	{
		return (-100 * index / numSlides) + "%";
	}

	function move(): void
	{
		$inner.css({ transform: "translate3d(" + getTranslateValue() + ",0,0)" });
		updateNavDisplay();
	}

	function prev(): void
	{
		if (index <= 0)
		{
			index = 0;
		}
		else
		{
			--index;
		}

		move();
	}

	function next(): void
	{
		if (index >= finalIndex)
		{
			index = finalIndex;
		}
		else
		{
			++index;
		}

		move();
	}

	function updateNavDisplay(): void
	{
		if (index > 0)
		{
			$prev.addClass("active");
		}
		else
		{
			$prev.removeClass("active");
		}

		if (index < finalIndex)
		{
			$next.addClass("active");
		}
		else
		{
			$next.removeClass("active");
		}
	}

	$prev.on("click", prev);
	$next.on("click", next);
	$(window).on("resize", move);
	updateNavDisplay();

	const hammer = new Hammer($wrap[0]);

	hammer.on("swipe", (e: any) => {
		switch (e.direction)
		{
			case 4:
				prev();
				break;
			case 2:
				next();
				break;
		}
	});

	function nextAutoslide()
	{
		setTimeout(() => {
			if (index >= finalIndex)
			{
				index = -1;
			}

			next();

			setTimeout(nextAutoslide, slideDurationEstimate);
		}, autoslideWait);
	}

	if (autoslideWait)
	{
		nextAutoslide();
	}
}
