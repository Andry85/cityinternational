import { each } from "lodash";

declare const $: any;

interface ITriggerFunc
{
	(): void
}

interface IThresholdGetter
{
	(): number
}

export function registerScrollDetectEvent(
	onPassForward: ITriggerFunc, 
	onPassBackward: ITriggerFunc,
	getThreshold?: IThresholdGetter
): void
{
	const regItem: IEventRegistryItem = {
		getThreshold: (getThreshold ? getThreshold : getDefaultThreshold),
		onPassForward,
		onPassBackward
	};

	eventRegistry.push(regItem);

	initialTrigger(regItem);
}

const config = Object.freeze({
	defaultThreshold: 200
});

function getDefaultThreshold()
{
	return config.defaultThreshold;
}

const $window: any = $(window);

function getScrollTop(): number
{
	return $window.scrollTop();
}

interface IEventRegistryItem 
{
	onPassForward: ITriggerFunc;
	onPassBackward: ITriggerFunc;
	getThreshold: IThresholdGetter;
}

const eventRegistry: IEventRegistryItem[] = [];

let prevScrollTop: number = getScrollTop();

function initialTrigger(regItem: IEventRegistryItem): void
{
	if (getScrollTop() >= regItem.getThreshold())
	{
		regItem.onPassForward();
	}
	else
	{
		regItem.onPassBackward();
	}
}

function hasScrolledForward(scrollTop: number, threshold: number): boolean
{
	return (prevScrollTop < threshold) && (scrollTop >= threshold);
}

function hasScrolledBackward(scrollTop: number, threshold: number): boolean
{
	return (prevScrollTop >= threshold) && (scrollTop < threshold);
}

function processEvent(scrollTop: number, regItem: IEventRegistryItem): void
{
	const threshold: number = regItem.getThreshold();

	if (hasScrolledForward(scrollTop, threshold))
	{
		regItem.onPassForward();
	}
	else if (hasScrolledBackward(scrollTop, threshold))
	{
		regItem.onPassBackward();
	}
}

function onScroll(): void
{
	const scrollTop: number = getScrollTop();

	each(eventRegistry, (regItem: IEventRegistryItem) => {
		processEvent(scrollTop, regItem);
	});

	prevScrollTop = scrollTop;
}

$window.on("scroll", onScroll);
