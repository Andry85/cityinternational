import { assert } from "chai";

declare const $: any;

export function dataAttr($e: any, attr: string, defaultValue: any = undefined)
{
	const value = $e.attr(`data-${attr}`);

	if (value === undefined)
	{
		return defaultValue;
	}

	return value;
}

export function dataAttrInt($e: any, attr: string, defaultValue: number = undefined)
{
	const value = dataAttr($e, attr, undefined);

	if (value === undefined)
	{
		return defaultValue;
	}

	return parseInt(value, 10);
}
