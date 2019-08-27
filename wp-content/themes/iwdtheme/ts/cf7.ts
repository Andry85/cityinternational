import { assert } from "chai";

declare const $: any;

export function init()
{
	fixRequired();
	fixLabelClick();
}

function fixRequired()
{
	$(".wpcf7-form :input[aria-required]").attr("required", "required");
}

function fixLabelClick()
{
	const $labels = $(".wpcf7-list-item-label");

	$labels.each(function eachLabel() {
		const $label = $(this);
		const $parent = $label.parent();
		const $radio = $parent.find("[type=\"radio\"]");
		
		if ($radio.length === 1)
		{
			$label
				.css({ cursor: "default" })
				.on("click", e => {
					$radio.prop("checked", true);
				});
			return;
		}

		const $checkbox = $parent.find("[type=\"checkbox\"]");

		if ($checkbox.length === 1)
		{
			$label
				.css({ cursor: "default" })
				.on("click", e => {
					$checkbox
						.prop("checked", !$checkbox.prop("checked"))
						.trigger("change");
				});
		}
	});
}
