declare const $: any;

const revealedClassName = "revealed";

export function init()
{
	const $toggle = $("[data-toggle-header-search]");
	const $popout = $("#header-search-popout");
	const $searchInput = $popout.find("input[name=\"s\"]");
	const $close = $popout.find("[data-search-close]");

	function focus()
	{
		const input = $searchInput.get(0);

		if (input)
		{
			input.focus();
		}
	}

	function toggle()
	{
		$popout.toggleClass(revealedClassName);

		if ($popout.hasClass(revealedClassName))
		{
			focus();
		}
	}

	function hide()
	{
		$popout.removeClass("revealed");
	}

	$toggle.on("click", () => {
		toggle();
		return false;
	});
	
	$close.on("click", () => {
		hide();
		return false;
	});
}
