import { assert } from "chai";
import { BannerItem } from "./banner-item-class";

declare const $: any;

export interface BannerAnimator
{
	initialize: (
		firstItem: BannerItem,
		items: BannerItem[]) => void;

	doTransition: (
		currentItem: BannerItem, 
		nextItem: BannerItem,
		transition: number) => Promise<any>;
}
