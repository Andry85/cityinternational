import { assert } from "chai";
import { BannerAnimator } from "./../banner-animator-interface";
import { BannerItem } from "./../banner-item-class";
import { each } from "lodash";

declare const $: any;

type Direction = "left" | "right";

export class SlideHorizontalAnimator implements BannerAnimator
{
	constructor(direction: Direction = "left")
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
					left: this.startLeft,
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

	private get startLeft(): string
	{
		return (this._direction === "left") ? "100%" : "-100%";
	}

	private get endLeft(): string
	{
		return (this._direction === "left") ? "-100%" : "100%";
	}

	private _transitionIn(nextItem: BannerItem, transition: number): Promise<any>
	{
		const $item = nextItem.$;

		$item.css({ left: this.startLeft, zIndex: 1 });

		return this._slide($item, transition, 0);
	}

	private _transitionOut(currentItem: BannerItem, transition: number): Promise<any>
	{
		const $item = currentItem.$;

		$item.css({ zIndex: 0 });

		return this._slide($item, transition, this.endLeft);
	}

	private _slide(
		$item: any, transition: number, targetLeft: string | number): Promise<any>
	{
		return new Promise((resolve, reject) => {
			$item.stop(true).animate({ left: targetLeft }, {
				duration: transition,
				complete: resolve
			});
		});
	}
}
