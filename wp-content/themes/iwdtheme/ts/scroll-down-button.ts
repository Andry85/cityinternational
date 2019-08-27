declare const $: any;

export function init()
{
	$(".scroll-button-container").each(initContainer);
}

const config = Object.freeze({
	duration: 400,
	settings: {
		offset: { top: -80 },
		axis: "y"
	}
});

function initContainer(): void
{
	const $container = $(this);

	const $button = $container.find(".scroll-down-button");

	$button.on("click", event => {
		$.scrollTo(
			getNextContainer($container), 
			config.duration, 
			config.settings
		);
	});
}

function getNextContainer($container: any): any
{
	while (true)
	{
		const $next: any = $container.next();

		if ($next.length > 0)
		{
			return $next;
		}
	
		$container = $container.parent();
		if ($container.length === 0)
		{
			return undefined;
		}
	}
}
