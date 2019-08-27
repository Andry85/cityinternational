declare const $: any;

export function init(): void
{
	$("[data-multipage]").each(function each() {
		initWrap($(this));
	});
}

function initWrap($wrap: any): void
{
	const $allSections = $wrap.find("[data-multipage-id]");
	const $allButtons = $wrap.find("[data-multipage-for]");

	$allButtons.each(function each(index: number) {
		const $btn = $(this);
		const id = $btn.attr("data-multipage-for");
		const $section = $allSections.filter(`[data-multipage-id="${id}"]`);

		function onClick()
		{
			hide($allSections.not($section), $allButtons.not($btn));
			show($section, $btn);
		}

		$btn.on("click", onClick);

		if (index === 0)
		{
			onClick();
		}
	});
}

function hide($section: any, $btn: any): void
{
	$section.removeClass("show");
	$btn.removeClass("selected");
}

function show($section: any, $btn: any): void
{
	$section.addClass("show");
	$btn.addClass("selected");
}
