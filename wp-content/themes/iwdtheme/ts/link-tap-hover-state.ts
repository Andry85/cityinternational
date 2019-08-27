// Link Tap Hover State
// ----------------------------------------------------------------------------

// Summary
// ----------------------------------------------------------------------------
// Sometimes we have big tile links or similar, where each tile is just an image
// by default, and has descriptive text appearing on mouse hover. To make this
// work with touchscreen devices, we use this CLJS module. The intended behaviour
// for each tile link on touchscreens becomes: on first tap, we apply the hover
// state (thereby revealing the text); on second tap, we allow the default
// click behaviour (i.e. follow the link).

// How to use: 
// ----------------------------------------------------------------------------
// (1) In CLJS, pass jQuery input (e.g. selector string) for all tile links
//     to this module's init-links function. (The tile links should be the <a>
//     elements or equivalent.)
// (2) In CSS, specify a .hover class for tile links which has identical rules
//     to their :hover pseudo-class.

// Example of usage at: thatfigures.illicitwebdesign.co.uk

// Dependency: jQuery mobile events plugin (for "tap" event).

// @fixme dependency - include somehow

declare const $: any;

const hoverClass = "hover";

// links arg can be anything that can be passed into jQuery()
export function init(links: any): void
{
	$(links).on("tap", function onTap() {
		const $link = $(this);

		if (!hovered($link))
		{
			hover($link);
			return false;
		}
	});
}

function hovered($link: any): void
{
	return $link.hasClass(hoverClass);
}

function hover($link: any): void
{
	$link.addClass(hoverClass);
}
