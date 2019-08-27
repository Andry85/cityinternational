import { assert } from "chai";

declare const $: any;

export function timedCalls(func: Function, numCalls: number, wait: number): void
{
	for (let counter = 0; counter < numCalls; ++counter)
	{
		setTimeout(func, wait * counter);
	}
}
