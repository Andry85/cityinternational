import * as Banner from "./banner";
import { initMainHeaderNav } from "./nav-sub-menus";
import { init as initScrolledBodyClass } from "./scrolled-body-class";
import { init as initBannerScrollBtns } from "./scroll-down-button";
import { init as initNavHamburger } from "./nav-hamburger";
import { init as initSearchPopout } from "./search-popout";
import { init as initBackToTop } from "./back-to-top";
import { init as initDatePickers } from "./date-pickers";
import { init as initCf7 } from "./cf7";
import { init as initLinkScroll } from "./link-scroll";
import { init as initSecondaryContentAnim } from "./secondary-content-anim";
import { init as initBlogArchive } from "./blog-archive";

//import { init as initLatestNewsStrip } from "./latest-news-strip";
//import { init as initMultipage } from "./multipage";
//import { init as initSideNav } from "./side-nav";
//import { init as initSideNavItems } from "./side-nav-items";
//import { init as initSlides } from "./slides";
//import { init as initSlideyGallery } from "./gallery/slidey-gallery";

declare const $: any;

initScrolledBodyClass();
initBannerScrollBtns();
initNavHamburger();
initMainHeaderNav();
initSearchPopout();
initBackToTop();
initDatePickers();
initCf7();
initLinkScroll();
initSecondaryContentAnim();
initBlogArchive();

//initLatestNewsStrip();
//initMultipage();
//initSideNav();
//initSideNavItems();
//initSlides();
//initSlideyGallery();

function setupMainBanner()
{
	const $banner = $("#top-banner > .iw-banner");
	
	if ($banner.length !== 1)
	{
		return;
	}

	const animator = new Banner.FadeAnimator();
	const banner = new Banner.Banner($banner, animator);
	banner.start();
}

setupMainBanner();


// ----------------------------------------------------------------------
// IE/Edge CSS object-fit polyfill
// https://www.npmjs.com/package/object-fit-images
require("object-fit-images")();
// ----------------------------------------------------------------------
