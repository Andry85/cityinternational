import { assert } from "chai";

import { fixHorizOverspill } from "./utils/layout";
import { timedCalls } from "./utils/misc";

declare const $: any;

const $window = $(window);
const $body = $("body");

const navSelector = ".illicit-nav";
const isOpenClass = "open";
const submenuSelector = ".sub-menu";
const openEvent = "open";

export function initNav(container): void
{
	const $nav = $(container).find(navSelector);
	const $allSubmenus = $nav.find(submenuSelector);

	if ($allSubmenus.length === 0)
	{
		return;
	}

	const $allLinks = $nav.find("li > a");

	closeOtherSubmenusOnMouseEnter($allSubmenus, $allLinks);

	closeAllSubmenusOnNavMouseLeave($allSubmenus, $nav);

	initAllSubmenus($allSubmenus, $nav);
}

export function initMainHeaderNav(): void
{
	initNav("#header");
}

function submenuIsOpen($submenu)
{
	return $submenu.hasClass(isOpenClass);
}

function getParentSubmenus($e)
{
	const $parents = $e.parents(submenuSelector);

	if ($e.is(submenuSelector))
	{
		$parents.add($e);
	}

	return $parents;
}

function getChildSubmenus($e)
{
	return $e.parent().find(submenuSelector);
}

function getSubmenuLineage($e)
{
	return getParentSubmenus($e).add(getChildSubmenus($e));
}

function closeSubmenus($submenus)
{
	$submenus.removeClass(isOpenClass);
}

function closeOtherSubmenus($allSubmenus, $theseSubmenus)
{
	const $otherSubmenus = $allSubmenus.not($theseSubmenus);

	closeSubmenus($otherSubmenus);
}

function fixSubmenuLayout($submenu)
{
	if (!$submenu.hasClass("no-layout-fix"))
	{
		timedCalls(() => fixHorizOverspill($submenu), 2, 120);
	}
}

function openSubmenu($allSubmenus, $submenu)
{
	closeOtherSubmenus($allSubmenus, getSubmenuLineage($submenu));

	$submenu.addClass(isOpenClass);

	$submenu.trigger(openEvent)

	fixSubmenuLayout($submenu);
}

function getSubmenuTopLink($menu)
{
	return $menu.parent("li").children("a");
}

function linkIsEmpty($link)
{
	const href = $link.attr("href");

	return !href || (href === "#");
}

function stopTouchPropagation($e)
{
	$e.on("touchstart", e => e.stopPropagation());
}

function openOnMouseEnter($allSubmenus, $submenu, $link)
{
	$link.on("mouseenter", e => {
		if (!submenuIsOpen($submenu))
		{
			openSubmenu($allSubmenus, $submenu);
			return false;
		}
	});
}

function closeOnMouseLeave($submenu)
{
	$submenu.on("mouseleave", e => closeSubmenus(getChildSubmenus($submenu)));
}

function openClosedSubmenuOnTouchend($allSubmenus, $submenu, $link)
{
	$link.on("touchend", e => {
		e.stopPropagation();

		if (!submenuIsOpen($submenu))
		{
			openSubmenu($allSubmenus, $submenu);
			return false;
		}
	});
}

function followOpenSubmenuLinkOnTouchend($submenu, $link)
{
	$link.on("touchend", e => {
		return submenuIsOpen($submenu);
	});
}

function preventFollowOnEmptyLinkClick($link)
{
	$link.on("click", e => {
		return !linkIsEmpty($link);
	});
}

function closeOtherSubmenusOnMouseEnter($allSubmenus, $allLinks)
{
	$allLinks.on("mouseenter", function (e) {
		e.stopPropagation();

		const $link = $(this);
		const $theseSubmenus = getParentSubmenus($link);

		closeOtherSubmenus($allSubmenus, $theseSubmenus);
	});
}

function closeAllSubmenusOnNavMouseLeave($allSubmenus, $nav)
{
	$nav.on("mouseleave", e => closeSubmenus($allSubmenus));
}

function initSubmenu($submenu, $allSubmenus, $nav)
{
	assert.strictEqual($nav.length, 1, "Nav length");
	assert.strictEqual($submenu.length, 1, "Submenu length");
	assert.isAbove($allSubmenus.length, 0, "All submenus length");
	
	const $link = getSubmenuTopLink($submenu);

	assert.strictEqual($link.length, 1, "Link length");

	stopTouchPropagation($link);

	openOnMouseEnter($allSubmenus, $submenu, $link);

	closeOnMouseLeave($submenu);

	followOpenSubmenuLinkOnTouchend($submenu, $link);

	openClosedSubmenuOnTouchend($allSubmenus, $submenu, $link);

	preventFollowOnEmptyLinkClick($link);

	fixSubmenuLayout($submenu); // for IE
}

function initAllSubmenus($allSubmenus, $nav)
{
	$allSubmenus.each(index => {
		const $submenu = $allSubmenus.eq(index);
		initSubmenu($submenu, $allSubmenus, $nav);
	});
}

