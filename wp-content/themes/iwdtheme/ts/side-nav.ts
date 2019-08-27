declare const $: any;

export function init(): void
{
	const $sideNav: any = $("#side-nav");
	const $openBtns: any = $("[data-open-side-nav]");
	const $closeBtns: any = $("[data-close-side-nav]");
	const $body: any = $("body");

	function toggle(): void
	{
		$sideNav.toggleClass("side-nav-open");
	}

	function closeSideNav(): void
	{
		$sideNav.removeClass("side-nav-open");
	}

	$sideNav.on("click", (e: any) => {
		e.stopPropagation();
	});

	$body.one("touchstart", (e: any) => $openBtns.off("click", toggle));

	$body.on("click", (e: any) => {
		closeSideNav();
	});

	$openBtns.on("click", (e: any) => {
		toggle();
		return false;
	});

	$openBtns.on("touchend", (e: any) => {
		$openBtns.off("click", toggle);
		e.preventDefault();
		toggle();
	});

	$closeBtns.on("click", (e: any) => {
		closeSideNav();
		return false;
	});


	// Optionally, set wipeLeft or wipeRight callback to close the side-nav here:

	$sideNav.touchwipe({
		// wipeLeft: () => {
		// 	closeSideNav();
		// },
		wipeRight: () => {
			closeSideNav();
		},
		preventDefaultEvents: false
	});
}
