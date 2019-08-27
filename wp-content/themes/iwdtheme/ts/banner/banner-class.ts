import { assert } from "chai";
import { BannerItem } from "./banner-item-class";
import { BannerAnimator } from "./banner-animator-interface";
import { dataAttrInt } from "./../utils/dom";
import {
	defaultWait, 
	defaultTransition,
	bannerItemSelector,
	ctrlOnClass,
	ctrlSelector
} from "./config";
import { each, map } from "lodash";

declare const $: any;

export class Banner
{
	constructor($banner: any, animator: BannerAnimator)
	{
		if ($banner.length !== 1)
		{
			throw new Error(`$banner must have length 1, has length ${$banner.length}`);
		}

		this._$banner = $banner;
		this._animator = animator;
		this._wait = dataAttrInt($banner, "wait", defaultWait);
		this._transition = dataAttrInt($banner, "transition", defaultTransition);
		this._items = this._buildItemsArray($banner);

		if (this._items.length > 0)
		{
			this._currentIndex = 0;
		}
	}

	public start(): void
	{
		assert.isDefined(this, "Expected this to be defined");
		assert.notEqual(window, this, "Expected non-window this");
		assert.instanceOf(this, Banner, "Expected this to be Banner instance");

		if (this.isActive)
		{
			console.warn("Banner already started; start call ignored");
			return;
		}

		this._isActive = true;

		this._animator.initialize(this.currentItem, this._items);

		if (this.length > 1)
		{
			this._startWait();
		}
	}

	public stop()
	{
		assert.isDefined(this, "stop Expected this to be defined");
		assert.notEqual(window, this, "stop Expected non-window this");
		assert.instanceOf(this, Banner, "stop Expected this to be Banner instance");

		this._clearTimeout.call(this);
		this._isActive = false;
	}

	public jumpToItem(index: number): void
	{
		assert.isDefined(this, "jumpToItem Expected this to be defined");
		assert.notEqual(window, this, "jumpToItem Expected non-window this");
		assert.instanceOf(this, Banner, "jumpToItem Expected this to be Banner instance");

		if (this._currentIndex === index)
		{
			return;
		}

		this._enforceValidIndex.call(this, index);
		this._cancelAnimation.call(this);
		this._clearTimeout.call(this);
		this._currentIndex = index;
		this._startWait.call(this);
	}

	private _startWait(): void
	{
		assert.instanceOf(this, Banner, "_startWait Expected this to be Banner instance");

		const self = this;

		self._clearTimeout.call(self);

		if (!self._isActive)
		{
			return;
		}

		self._waitTimer = setTimeout(() => self._endWait(), self.currentItem.wait);
	}

	private _endWait(): void
	{
		assert.instanceOf(this, Banner, "_endWait Expected this to be Banner instance");

		const self = this;

		self._animator
			.doTransition(
				self.currentItem, 
				self.nextItem,
				self.currentItem.transition)
			.then(() => self._moveOnToNextItem());
	}

	private _moveOnToNextItem(): void
	{
		assert.instanceOf(this, Banner, "_moveOnToNextItem Expected this to be Banner instance");

		this._incrementIndex.call(this);
		this._startWait.call(this);
	}

	private _buildItemsArray($banner: any): BannerItem[]
	{
		assert.instanceOf(this, Banner, "_buildItemsArray Expected this to be Banner instance");

		const $items = $banner.find(bannerItemSelector);
																																										11
		if ($items.length === 0)
		{
			return [];
		}

		return map(
			$items.toArray(), 
			itemContainer => new BannerItem($(itemContainer), this)
		);
	}

	private _initUserControls($banner: any): void 
	{
		assert.instanceOf(this, Banner, " _initUserControls expected this to be Banner instance");

		const $ctrls = $banner.find(ctrlSelector);

		this._hasUserControls = ($ctrls.length > 0);

		if (!this.hasUserControls)
		{
			return;
		}

		const self = this;

		if (this.length < 2)
		{
			$ctrls.remove();
			return;
		}

		$ctrls.each(itemIndex => {
			const $ctrl = $ctrls.eq(itemIndex);

			$ctrl.on("click", e => {
				self.jumpToItem(itemIndex);
				$ctrls.removeClass(ctrlOnClass);
				$ctrl.addClass(ctrlOnClass);
			});
		});
	}

	public get wait(): number
	{
		return this._wait;
	}

	public get transition(): number
	{
		return this._transition;
	}

	public get length(): number
	{
		return this._items.length;
	}

	public get hasUserControls(): boolean
	{
		return this._hasUserControls;
	}

	public get currentItem(): BannerItem
	{
		return this._items[this.currentIndex];
	}

	public get nextItem(): BannerItem
	{
		return this._items[this.nextIndex];
	}

	public get currentIndex(): number
	{
		return this._currentIndex;
	}

	public get nextIndex(): number
	{
		const currentIndex = this.currentIndex;

		if (currentIndex === null)
		{
			return null;
		}

		const nextIndex = currentIndex + 1;

		if (nextIndex >= this.length)
		{
			return 0;
		}

		return nextIndex;
	}

	public get isActive()
	{
		return this._isActive;
	}

	private _currentIndex: number | null = null;
	private _wait: number;
	private _transition: number;
	private _$banner: any;
	private _animator: BannerAnimator;
	private _items: BannerItem[] = [] as BannerItem[];
	private _hasUserControls: boolean;
	private _waitTimer: any = null
	private _isActive: boolean = false;
	
	private _clearTimeout(): void
	{
		clearTimeout(this._waitTimer);
		this._waitTimer = null;
	}

	private _cancelAnimation(): void
	{
		each(this._items, item => item.cancelAnimation());
	}

	private _safeSetCurrentIndex(index: number)
	{
		this._enforceValidIndex.call(this, index);
		this._currentIndex = index;
	}

	private _incrementIndex(): void
	{
		if (this.length === 0)
		{
			return;
		}

		this._safeSetCurrentIndex.call(this, this.nextIndex);
	}

	private _indexIsValid(index: number): boolean
	{
		if (this.length === 0 && index === null)
		{
			return true;
		}

		return (index >= 0) && (index < this.length);
	}

	private _enforceValidIndex(index: number): void
	{
		if (!this._indexIsValid(index))
		{
			throw new Error(`Invalid banner item index: ${index}`);
		}
	}
}
