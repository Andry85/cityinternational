declare const $: any;

export function init(): void
{
	const $sideNav: any = $("#side-nav");
	const $linksWithChildren = $sideNav.find("li.menu-item-has-children > a");

	if ($linksWithChildren.length === 0)
	{
		return;
	}

	$linksWithChildren.on("click", function (event: any) {
		const $a = $(this);
		const $li = $a.parent();
		if ($li.hasClass("open"))
		{
			// Follow link
			return;
		}

		openItem($li, $linksWithChildren);

		event.preventDefault();
		return false;
	});
}

function openItem($li, $linksWithChildren): void
{
	$linksWithChildren.parent().removeClass("open");
	$li.addClass("open");
}
