import { assert } from "chai";
import { Banner } from "./banner-class";
import { dataAttrInt } from "./../utils/dom";

declare const $: any;

export class BannerItem
{
	constructor($container, banner: Banner)
	{
		this._$container = $container;
		this._$contents = $container.find("*");
		this._wait = dataAttrInt($container, "wait", banner.wait);
		this._transition = dataAttrInt($container, "transition", banner.transition);
	}

	private _wait: number;
	private _transition: number;
	private _$container: any;
	private _$contents: any;

	public cancelAnimation(): void
	{
		this._$container.stop(true);
		this._$contents.stop(true);
	}

	public get wait(): number
	{
		return this._wait;
	}

	public get transition(): number
	{
		return this._transition;
	}

	public get $(): any
	{
		return this._$container;
	}
}
