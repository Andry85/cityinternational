import { registerScrollDetectEvent } from "./scroll-detect";

declare const $: any;

const openClassName = "open";

const $body = $("body");

export function init(): void
{
	const $nav = $("#header .illicit-nav");

	if ($nav.length < 1)
	{
		console.warn(".illicit-nav element not found");
		return;
	}

	const $hamburger = $("<span class=\"hamburger\"><span></span><span></span><span></span></span>");

	$nav.prepend($hamburger);

	const $menu = $nav.find("ul.menu");

	$hamburger.on("click", e => {
		if (isOpen($menu))
		{
			closeMenu($menu);
		}
		else
		{
			openMenu($menu);
		}

		return false;
	});
}

function isOpen($menu: any): boolean
{
	return $menu.hasClass(openClassName);
}

function findSubmenus($container: any): any
{
	return $container.find("ul.sub-menu");
}

function openMenu($menu: any): void
{
	if (!isOpen($menu))
	{
		$menu.addClass(openClassName);

		$body.one("click touchend", e => {
			closeMenu($menu);
		});
	}
}

function closeMenu($menu: any): void
{
	if (isOpen($menu))
	{
		$menu.removeClass(openClassName);
		findSubmenus($menu).removeClass(openClassName);
	}
}
