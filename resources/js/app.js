import * as functions from "./modules/functions.js";

import.meta.glob([
	'../img/**',
]);

// Default Laravel bootstrapper, installs axios
import './bootstrap';

// Added: Actual Bootstrap JavaScript dependency
import 'bootstrap';

// Added: Popper.js dependency for popover support in Bootstrap
import '@popperjs/core';

function TelegramAPI() {
	const tg = window.Telegram.WebApp;
	tg.headerColor = '#53158a';
	tg.backgroundColor = '#53158a';
	tg.isVerticalSwipesEnabled = false;
	tg.expand();
}

TelegramAPI();

if (document.querySelector('main.choice_new')) {
	functions.openAddVariant();
	functions.addMediaPreview();
	functions.addYouTubePreview();
	// functions.addVariantToList();
	// functions.updateVariantInList();
	functions.switchMediaSource();
	functions.getFileName();
}

if (document.querySelector('main.choice_edit')) {
	functions.getFileName();
}

if (document.querySelector('main.expert_new')) {
	functions.newExpertPage();
}

if (document.querySelector('main.deposit_page')) {
	functions.validateDepositForm();
}
