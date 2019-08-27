import { assert } from "chai";
import { BannerAnimator } from "./../banner-animator-interface";
import { BannerItem } from "./../banner-item-class";
import { each } from "lodash";

declare const $: any;

export class SlideLeftAnimator implements BannerAnimator
{
	initialize(firstItem: BannerItem|void, items: BannerItem[])
	{
		each(items, item => {
			if (item !== firstItem)
			{
				item.$.css({ zIndex: 0, opacity: 0 });
			}
		});

		if (firstItem)
		{
			firstItem.$.css({ zIndex: 1, opacity: 1 });
		}
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

	private _transitionIn(nextItem: BannerItem, transition: number): Promise<any>
	{
		const $item = nextItem.$;

		$item.css({ zIndex: 1 });

		return this._fade($item, transition, 0.99);
	}

	private _transitionOut(currentItem: BannerItem, transition: number): Promise<any>
	{
		const $item = currentItem.$;

		$item.css({ zIndex: 0 });

		return this._fade($item, transition, 0);
	}

	private _fade($item: any, transition: number, targetOpacity: number): Promise<any>
	{
		return new Promise((resolve, reject) => {
			$item.stop(true).animate({ opacity: targetOpacity }, {
				duration: transition,
				complete: resolve
			});
		});
	}
}
