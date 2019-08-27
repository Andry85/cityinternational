// Initializes jQuery UI date pickers.

// Inputs must have type="text" and a data-date-input attribute.

// Optionally you may put a default date as the data-date-input value.

// Also you may specify date-min-date, data-max-date, data-date-format.

// data-min-date, data-max-date, data-date-input date values must be specified
// in the format given by data-date-format (or the default date format if
// data-date-format is not specified).

// See defaultDateFormat constant for the default date format (below).

import { assert } from "chai";

import { dataAttr } from "./utils/dom";

const defaultDateFormat = "yy/mm/dd";

declare const $: any;

export function init()
{
	$("[data-date-input]").each(function eachInput() {
		const $input = $(this);
		const minDate = dataAttr($input, "min-date");
		const maxDate = dataAttr($input, "max-date");
		const defaultDate = dataAttr($input, "date-input", "");
		const dateFormat = dataAttr($input, "date-format", defaultDateFormat);

		$input.datepicker({
			minDate,
			maxDate,
			dateFormat
		}).val(defaultDate);
	});
}
