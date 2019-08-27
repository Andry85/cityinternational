import { debounce } from "lodash";

declare const IW_ON_MOBILE: boolean;
declare const jQuery: any;

export function init()
{
	const $: any = jQuery;
	const $window = $(window);
	const config = Object.freeze({
		slideBackToStart: true,
		duration: 350,
		mobileDownwards: 500, // viewport width px - sync with scss var (main.scss)
		mainSlideDuration: 350
	});

	// Entry point
	function main()
	{
		forEachGallery(initGallery);
		preloadFullImages();
		hideElementsIfNoThumbs();
		disableImageDrag();
	}

	function disableImageDrag()
	{
		$('.pg-item img').on('dragstart', function onDragStart(ev) {
			return false;
		});
	}

	function hideElementsIfNoThumbs()
	{
		if (noThumbs())
		{
			$('#pretty-thumbs-main-img [data-nav]').remove();
			$('#pretty-thumbs-main-img').addClass('inactive');
		}
	}

	function noMainImage()
	{
		return !document.getElementById('pretty-thumbs-main-img');
	}

	function noThumbs()
	{
		return ($('.pg-item').length === 0);
	}

	function forEachGallery(fn)
	{
		$('.iw-pretty-thumbs').each(fn);
	}

	function initGallery()
	{
		var $gallery = $(this);
		var $elements = {
			$gallery: $gallery,
			$scrollable: $gallery.find('.pg-middle'),
			$inner: $gallery.find('.pg-inner'),
			$items: $gallery.find('.pg-item'),
			$prev: $gallery.find('.pg-prev'),
			$next: $gallery.find('.pg-next'),
			$big: $gallery.find('.pg-big'),
			$mainImageWrap: $('#pretty-thumbs-main-img'),
			$mainImage: $('#pretty-thumbs-main-img > div')
		};

		whenImagesLoaded($elements, function imagesLoaded() {
			initNavBtns($elements); // adds click events to nav btns
			setScroll($elements, 0);
			setNavDisplay($elements); // hides/reveals nav btns as necessary
			initItems($elements);
			initMainImage($elements);
			initMainImageNav($elements);
			setupTouch($elements);
			setupMainImageMaxHeight($elements);
			setupAfterScroll($elements);
		});
	}

	// After a user has scrolled, we want to hide/reveal thumb nav btns
	// as appropriate.
	function setupAfterScroll($elements)
	{
		$elements.$scrollable.on('scroll', debounce(function onScroll(ev) {
			setNavDisplay($elements);
		}));
	}

	function setupTouch($elements)
	{
		ifOnTouchScreen(function onTouchScreen() {
			// Remove unnecessary elements for touch screens
			// Init swipe action on main img
			initTouchSwipe($elements);
		});
	}

	function ifOnTouchScreen(fn)
	{
		if ((typeof IW_ON_MOBILE !== 'undefined') && IW_ON_MOBILE)
		{
			fn();
		}
		else
		{
			$('body').one('touchstart touchend touchmove', fn);
		}
	}

	function removeNavBtns($elements)
	{
		$elements.$mainImageWrap.find('[data-nav]').remove();
	}

	function hideGallery($elements)
	{
		$elements.$gallery.hide();
	}

	function initTouchSwipe($elements)
	{
		var $img = $elements.$mainImage;
		$img.touchwipe({
			preventDefaultEvents: false,
			wipeLeft: function wipeLeft(ev)
			{
				incrementHighlightedItem($elements);
			},
			wipeRight: function wipeRight(ev)
			{
				decrementHighlightedItem($elements);
			},
			allowPageScroll: 'vertical'
		});
	}

	function initItems($elements)
	{
		$elements.$items.on('click', function onClick() {
			var $item = $(this);
			selectImageFromItem($elements, $item, undefined);
			return false;
		});

		if (!noMainImage())
		{
			highlightFirstItem($elements);
		}
	}

	function highlightFirstItem($elements)
	{
		var $item = $elements.$items.first();
		if ($item.length > 0)
		{
			highlightThumb($elements, $item);
		}
	}

	function initMainImage($elements)
	{
		var $img = $elements.$mainImage;
		$img.on('click', function onClick(ev) {
			var $item = getHighlightedItem($elements);
			showBigPic($elements, $item);
		});
	}

	function getHighlightedItem($elements)
	{
		return $elements.$items.find('img').filter('.highlight').closest('.pg-item');
	}

	function initMainImageNav($elements)
	{
		var $wrap = $elements.$mainImageWrap;

		$wrap.find('[data-nav="prev"]').on('click', function onClick(ev) {
			decrementHighlightedItem($elements);
			return false;
		});

		$wrap.find('[data-nav="next"]').on('click', function onClick(ev) {
			incrementHighlightedItem($elements);
			return false;
		});
	}

	function incrementHighlightedItem($elements)
	{
		bumpHighlightedItem($elements, 'next', 'first');
	}

	function decrementHighlightedItem($elements)
	{
		bumpHighlightedItem($elements, 'prev', 'last');
	}

	function bumpHighlightedItem($elements, nextOrPrev, firstOrLast)
	{
		var $items = $elements.$items;
		var $oldItem = getHighlightedItem($elements);
		var $newItem = $oldItem[nextOrPrev]('.pg-item');
		if ($newItem.length === 0)
		{
			$newItem = $items[firstOrLast]();
		}
		selectImageFromItem($elements, $newItem, nextOrPrev);
		scrollItemIntoView($elements, $newItem);
	}

	function scrollItemIntoView($elements, $item)
	{
		if (!itemIsVisible($elements, $item))
		{
			scrollToItem($elements, $item);
		}
	}

	function itemIsVisible($elements, $item)
	{
		var $scrollable = $elements.$scrollable;
		var width = $scrollable.width();
		var scrolled = $scrollable.scrollLeft();
		var itemLeft = $item.position().left;
		var itemRight = itemLeft + $item.outerWidth();
		return (itemLeft >= scrolled) && (itemRight < (scrolled + width));
	}

	function selectImageFromItem($elements, $item, nextOrPrev)
	{
		var src = $item.find('img').attr('data-url');
		if (noMainImage())
		{
			showBigPic($elements, $item, true);
		}
		else
		{
			changeMainImage($elements, src, nextOrPrev);
			highlightThumb($elements, $item);
		}
	}

	function changeMainImage($elements, src, nextOrPrev)
	{
		slideInTempMainImage($elements, src, nextOrPrev,

			function onTempSlideSuccess($tempImage)
			{
				setMainImageSrc($elements, src,

					function onLoad()
					{
						$tempImage.remove();
					},

					function onError()
					{
						$tempImage.remove();
					}
				);
			}
		);
	}

	function slideInTempMainImage($elements, src, nextOrPrev, onSuccess, onError?)
	{
		tryImageLoad(src, function done(success) {
			if (!success)
			{
				onError();
				return;
			}

			var $tmpImage = $('<div class="tmp-image">')
				.css({
					backgroundImage: 'url("' + src + '")'
				});

			if (nextOrPrev === 'prev')
			{
				$tmpImage.css({
					left: '-100%'
				});
			}

			$tmpImage.appendTo($elements.$mainImageWrap);

			$tmpImage.animate({ left: 0 }, config.mainSlideDuration, function animDone() {
				onSuccess($tmpImage);
			});
		});
	}

	function setMainImageSrc($elements, src, onLoad, onError)
	{
		$elements.$mainImage.css({
			backgroundImage: 'url("' + src + '")'
		});

		var img = new Image();

		img.onload = function ()
		{
			if (onLoad)
			{
				onLoad();
			}
		};

		img.onerror = function ()
		{
			if (onError)
			{
				onError();
			}
		};

		img.src = src;
	}

	function highlightThumb($elements, $item)
	{
		unhighlightAllThumbs($elements);
		$item.find('img').addClass('highlight');
	}

	function unhighlightAllThumbs($elements)
	{
		$elements.$items.find('img').removeClass('highlight');
	}

	function setScroll($elements, scroll)
	{
		$elements.$scrollable.scrollLeft(scroll);
	}

	function whenImagesLoaded($elements, fn)
	{
		var $images = $elements.$items.find('img');
		var numImages = $images.length;
		var numComplete = 0;
		$images.each(function each() {
			var $image = $(this);
			tryImageLoad($image.attr('src'), function complete(success) {
				++numComplete;
				if (!success)
				{
					$image.remove();
				}
				if (numComplete === numImages)
				{
					fn();
				}
			});
		});
	}

	function tryImageLoad(src, fn)
	{
		var img = new Image();
		img.onload = function onLoad() {
			fn(true, img);
		};
		img.onerror = function onError() {
			fn(false);
		};
		img.src = src;
	}

	function scrollToItem($elements, $item)
	{
		$elements.$scrollable.stop(true).scrollTo($item, {
			axis: 'x',
			duration: config.duration,
			onAfter: function onAfter() {
				afterScroll($elements, $item);
			}
		});
	}

	function scrollToFirstItem($elements)
	{
		var item = getFirstItem($elements);
		if (item) {
			scrollToItem($elements, item[0]);
		}
	}

	function scrollToPrevItem($elements)
	{
		var item = getPrevItem($elements);
		if (item) {
			scrollToItem($elements, item[0]);
		}
	}

	function scrollToNextItem($elements)
	{
		var item = getNextItem($elements);
		if (item) {
			scrollToItem($elements, item[0]);
		}
	}

	function afterScroll($elements, $item)
	{
		correctScroll($elements, $item);
		setNavDisplay($elements);
	}

	function correctScroll($elements, $item)
	{
		var left = Math.round($item.position().left);
		$elements.$scrollable.scrollLeft(left);
	}

	// If one or both nav btns are needed, they are revealed, else they are
	// hidden.
	function setNavDisplay($elements)
	{
		if (prevBtnNeeded($elements))
		{
			revealPrevBtn($elements);
		}
		else
		{
			hidePrevBtn($elements);
		}
		if (nextBtnNeeded($elements))
		{
			revealNextBtn($elements);
		}
		else
		{
			hideNextBtn($elements);
		}
	}

	function hidePrevBtn($elements)
	{
		hideBtn($elements.$prev);
	}

	function hideNextBtn($elements)
	{
		hideBtn($elements.$next);
	}

	function hideBtn($btn)
	{
		$btn.stop(true);
		if (hidden($btn))
		{
			$btn.css({
				display: 'none'
			});
		}
		else
		{
			$btn.animate({
				opacity: 0
			}, 250, function complete() {
				$btn.css({
					display: 'none'
				});
			});
		}
	}

	function revealPrevBtn($elements)
	{
		revealBtn($elements.$prev);
	}

	function revealNextBtn($elements)
	{
		revealBtn($elements.$next);
	}

	function revealBtn($btn)
	{
		$btn.stop(true);
		if (revealed($btn))
		{
			$btn.css({
				display: '',
				opacity: 1
			});
		}
		else
		{
			$btn.css({
				opacity: 0,
				display: ''
			}).animate({
				opacity: 1
			}, 350);
		}
	}

	function hidden($e)
	{
		return !revealed($e);
	}

	function revealed($e)
	{
		return $e.is(':visible');
	}

	// @return {bool}
	function prevBtnNeeded($elements)
	{
		return !scrollAtMin($elements);
	}

	// @return {bool}
	function scrollAtMin($elements)
	{
		return ($elements.$scrollable.scrollLeft() === 0);
	}

	// @return {bool}
	function nextBtnNeeded($elements)
	{
		if (config.slideBackToStart)
		{
			// If we're doing the slide-to-start thing, we always want a
			// 'next' button because it's that what triggers the slide-back
			// once we're at the max scroll position.
			return true;
		}
		else
		{
			// ...Otherwise, hide the 'next' button when we're scrolled to max.
			return !scrollAtMax($elements) && contentsWiderThanContainer($elements);
		}
	}

	function contentsWiderThanContainer($elements)
	{
		return getTotalItemWidth($elements) > $elements.$gallery.width();
	}

	// @return {bool}
	function scrollAtMax($elements)
	{
		var scroll = $elements.$scrollable.scrollLeft();
		var maxScroll = getMaxScroll($elements);
		return (scroll == maxScroll);
	}

	// @return {int}
	function getMaxScroll($elements)
	{
		return -($elements.$scrollable.width() - getTotalItemWidth($elements));
	}

	// @return {array|null} [0] $ for first item el, [1] index (which will be
	// zero) or null if there is no first item
	function getFirstItem($elements)
	{
		var $item = $elements.$items.first();
		if ($item.length === 1)
		{
			return [$item, 0];
		}
		else
		{
			return null;
		}
	}

	// @return {array|null} [0] $ for prev item el, [1] index,
	// or null if there is no prev item
	function getPrevItem($elements)
	{
		var prev = null;
		var $items = $elements.$items;
		var numItems = $items.length;
		var $item;
		var left;
		var right;
		var scroll = $elements.$scrollable.scrollLeft();

		for (var itemIndex = 0; itemIndex < numItems; ++itemIndex)
		{
			$item = $items.eq(itemIndex);
			left = Math.ceil($item.position().left);
			right  = left + $item.outerWidth();
			if ((scroll > left) && (scroll <= right))
			{
				prev = [$item, itemIndex];
				break;
			}
		}
		return prev;
	}

	// @return {array|null} [0] $ for next item el, [1] next item's index,
	// or null if there is no next item
	function getNextItem($elements)
	{
		var prev = getPrevItem($elements);
		var next = null;
		if (prev === null)
		{
			next = [$elements.$items.eq(1), 1];
		}
		else {
			var prevIndex = prev[1];
			var nextIndex = prevIndex + 2;
			var lastIndex = $elements.$items.length - 1;
			if (nextIndex <= lastIndex)
			{
				next = [$elements.$items.eq(nextIndex), nextIndex];
			}
		}
		return next;
	}

	function getTotalItemWidth($elements, upToIndex?)
	{
		var $items = $elements.$items;
		var w = 0;
		$items.each(function (index) {
			if (upToIndex !== undefined && index === upToIndex) {
				return false;
			}
			w += $(this).outerWidth(true);
			return true;
		});
		return w;
	}

	function initNavBtns($elements)
	{
		$elements.$prev.on('click', function onClick(e) {
			scrollToPrevItem($elements);
			return false;
		});

		$elements.$next.on('click', function onClick(e) {
			if (config.slideBackToStart && scrollAtMax($elements))
			{
				scrollToFirstItem($elements);
			}
			else
			{
				scrollToNextItem($elements);
			}
			return false;
		});
	}

	function showBigPic($elements, $item, isNew = true)
	{
		if ($window.width() <= config.mobileDownwards)
		{
			return;
		}

		var $prevItem = $item.prev();
		var $nextItem = $item.next();

		var $oldBig = $('.pg-big');

		var $img = $item.find('img');
		var src = $img.attr('data-url');
		var caption = $img.attr('data-caption');

		var $big = $('<div class="pg-big">')
			.on('click', function onClick() {
				$('.pg-big').remove();
			})
			.appendTo('body');

		var $innerDiv = $('<div>')
			.appendTo($big)
			.css({
				backgroundImage: 'url("'+src+'")'
			});

		$('<div class="pg-big-close">').appendTo($big);

		if (caption)
		{
			$('<div class="pg-big-caption">')
				.html(caption)
				.appendTo($big);
		}

		if ($prevItem.length > 0)
		{
			$('<span class="pg-big-prev">')
			.on('click', function onClick(ev) {
				showBigPic($elements, $prevItem, false);
				return false;
			})
			.appendTo($big);
		}

		if ($nextItem.length > 0)
		{
			$('<span class="pg-big-next">')
			.on('click', function onClick(ev) {
				showBigPic($elements, $nextItem, false);
				return false;
			})
			.appendTo($big);
		}

		function onFail()
		{
			$('.pg-big').remove();
		}

		tryImageLoad(src, function loaded(success, img) {

			if (!success) {
				onFail();
				return;
			}

			var w = img.width;
			var h = img.height;

			if (w < 26 || h < 26) {
				onFail();
				return;
			}

			var containerWidth = $innerDiv.width();
			var containerHeight = $innerDiv.height();

			if (w > containerWidth || h > containerHeight)
			{
				$innerDiv.css({
					backgroundSize: 'contain'
				});
			}

			var className = isNew ? 'revealed' : 'quick-revealed';

			setTimeout(function () {
				$big.addClass(className);
			}, 70);
		});
	}

	function preloadFullImages()
	{
		$('.iw-pretty-thumbs img[data-url]').each(function eachImg() {
			var src = $(this).attr('data-url');
			var img = new Image();
			img.src = src;
			img.onerror = function onError() {
				console.error("Failed to load full-size image: " + src);
			};
		});
	}

	function setupMainImageMaxHeight($elements)
	{
		var $wrap = $elements.$mainImageWrap;

		function correctMaxHeight()
		{
			$wrap.css({ maxHeight: '' });
			var height = $wrap.height();
			$wrap.css({ maxHeight: height });
		}

		correctMaxHeight();
		$window.on('resize load', correctMaxHeight);
	}

	main();
}
