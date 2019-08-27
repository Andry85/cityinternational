import { assert } from "chai";
import { BannerAnimator } from "./../banner-animator-interface";
import { BannerItem } from "./../banner-item-class";
import { each } from "lodash";

declare const $: any;

type Direction = "up" | "down";

export class SlideVerticalAnimator implements BannerAnimator
{
	constructor(direction: Direction = "down")
	{
		this._direction = direction;
	}

	private _direction: Direction;

	public initialize(firstItem: BannerItem|void, items: BannerItem[])
	{
		if (firstItem)
		{
			firstItem.$.css({ zIndex: 1, opacity: 1 });
		}

		each(items, item => {
			item.$.css({ backgroundAttachment: "scroll" });

			if (item !== firstItem)
			{
				item.$.css({
					zIndex: 0, 
					top: this.startTop,
					opacity: 1
				});
			}
		});
	}

	public doTransition(
		currentItem: BannerItem, 
		nextItem: BannerItem,
		transition: number): Promise<any>
	{
		return Promise.all([
			this._transitionOut(currentItem, transition),
			this._transitionIn(nextItem, transition)
		]);
	}

	private get startTop(): string
	{
		return (this._direction === "down") ? "-100%" : "100%";
	}

	private get endTop(): string
	{
		return (this._direction === "down") ? "100%" : "-100%";
	}

	private _transitionIn(nextItem: BannerItem, transition: number): Promise<any>
	{
		const $item = nextItem.$;

		$item.css({ top: this.startTop, zIndex: 1 });

		return this._slide($item, transition, 0);
	}

	private _transitionOut(currentItem: BannerItem, transition: number): Promise<any>
	{
		const $item = currentItem.$;

		$item.css({ zIndex: 0 });

		return this._slide($item, transition, this.endTop);
	}

	private _slide(
		$item: any, transition: number, targetTop: string | number): Promise<any>
	{
		return new Promise((resolve, reject) => {
			$item.stop(true).animate({ top: targetTop }, {
				duration: transition,
				complete: resolve
			});
		});
	}
}
