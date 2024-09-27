const Youtube = (function () {
	'use strict';

	let video, results;

	var getThumb = function (url, size) {
		if (url === null) {
			return '';
		}
		size = (size === null) ? 'big' : size;
		results = url.match('[\\?&]v=([^&#]*)');
		video = (results === null) ? url : results[1];

		if (size === 'small') {
			return 'http://img.youtube.com/vi/' + video + '/2.jpg';
		}
		return 'http://img.youtube.com/vi/' + video + '/0.jpg';
	};

	return {
		thumb: getThumb
	};
}());

export function openAddVariant() {
	const addNewButton = document.querySelector('.variant__add');

	document.querySelector('#variant_list .variant .delete_variant').addEventListener('click', deleteVariant)

	const choiceNameEl = document.querySelector('#variant_list .variant .choice_name');
	const mediaSourceSwitcherEl = document.querySelector('#variant_list .variant .media-source-switcher');
	const inputFileEl = document.querySelector('#variant_list .variant .input-file');
	const choiceMediaUrlEl = document.querySelector('#variant_list .variant .choice_media_url');
	const mediaPreviewEl = document.querySelector('#variant_list .variant .media_preview');
	const choiceDescriptionEl = document.querySelector('#variant_list .variant .choice_description');
	const choiceDeleteButtonEl = document.querySelector('#variant_list .variant .delete_variant');

	addNewButton.addEventListener('click', addNewVariant);

	function addNewVariant() {

		let variantItem = document.createElement("div");
		variantItem.classList.add('variant');
		variantItem.innerHTML = choiceNameEl.outerHTML + mediaSourceSwitcherEl.outerHTML + inputFileEl.outerHTML + choiceMediaUrlEl.outerHTML + mediaPreviewEl.outerHTML + choiceDescriptionEl.outerHTML + choiceDeleteButtonEl.outerHTML;
		variantItem.querySelectorAll('.media-source-switcher div').forEach(element => element.addEventListener('click', switchInput));
		variantItem.querySelector('.choice_media').addEventListener('change', ChangeMediaFile);
		variantItem.querySelector('.choice_media_url').addEventListener('input', YouTubeInputURL);
		variantItem.querySelector('.media_preview').innerHTML = '';
		variantItem.querySelector('.delete_variant').addEventListener('click', deleteVariant);

		document.querySelector('#variant_list').append(variantItem);

		const countVariants = document.querySelectorAll('#variant_list .variant').length;
		const variantAddButton = document.querySelector('.variant__add');

		if (countVariants === 4) {
			variantAddButton.classList.add('hide');
		}

		validateForm();
	}
}

export function addMediaPreview() {
	const MediaFile = document.querySelectorAll('.choice_media');
	MediaFile.forEach(element => element.addEventListener('change', ChangeMediaFile));
}

export function addYouTubePreview() {
	const YouTubeURL = document.querySelectorAll('.choice_media_url');
	YouTubeURL.forEach(element => element.addEventListener('input', YouTubeInputURL));
}

export function switchMediaSource() {
	const MediaSourceSwitcherEls = document.querySelectorAll('.media-source-switcher div');
	MediaSourceSwitcherEls.forEach(element => element.addEventListener('click', switchInput));
}

export function newExpertPage() {
	document.querySelector('.expert_new .expert_image').addEventListener('change', PreviewAva);
}

export function getFileName () {
	const fileInputs = document.querySelectorAll('input.choice_media');

	fileInputs.forEach(function(item, i, arr) {
		item.addEventListener("change", handleFiles);
	});

	function handleFiles() {
		const parentEl = this.closest('.input-file');

		parentEl.querySelector('span').innerHTML = this.files[0].name
	}
}


function YouTubeInputURL() {
	let parentBlock = this.closest('.variant');

	parentBlock.querySelector('.media_preview').innerHTML = '';

	let url = this.value;
	const checkLink = url.replace("http://", "").replace("https://", "").replace("www.", "").replace("youtu.be/", "youtube.com/watch?v=").slice(0, 20) === "youtube.com/watch?v=";

	if (checkLink) {
		let img = document.createElement('img');
		img.src = Youtube.thumb(this.value);

		parentBlock.querySelector('.media_preview').appendChild(img);
	} else {
		parentBlock.querySelector('.media_preview').innerHTML = '';
	}
}

function switchInput() {
	this.closest('.media-source-switcher').querySelector('.active').classList.remove('active');
	this.classList.add('active');

	let parentBlock = this.closest('.variant');

	parentBlock.querySelector('.media_preview').innerHTML = '';
	parentBlock.querySelector('.choice_media').value = '';
	parentBlock.querySelector('.choice_media_url').value = '';

	const mediaSource = this.dataset.media;

	if (mediaSource === 'Device') {
		parentBlock.querySelector('.input-file').classList.remove('hide');
		parentBlock.querySelector('.choice_media_url').classList.add('hide');
	} else {
		parentBlock.querySelector('.input-file').classList.add('hide');
		parentBlock.querySelector('.choice_media_url').classList.remove('hide');
	}

	// validateInputs();
}

function PreviewAva(event) {
	let parentBlock = this.closest('.expert_new');

	let file = event.target.files[0];
	let fileReader = new FileReader();
	if (file.type.match('image')) {
		fileReader.onload = function () {
			let img = document.createElement('img');
			img.src = fileReader.result;
			parentBlock.querySelector('.media_preview').innerHTML = '';
			parentBlock.querySelector('.media_preview').appendChild(img);
		};
		fileReader.readAsDataURL(file);
	} else {
		fileReader.onload = function () {
			let blob = new Blob([fileReader.result], {type: file.type});
			let url = URL.createObjectURL(blob);
			let video = document.createElement('video');
			let timeupdate = function () {
				if (snapImage()) {
					video.removeEventListener('timeupdate', timeupdate);
					video.pause();
				}
			};
			video.addEventListener('loadeddata', function () {
				if (snapImage()) {
					video.removeEventListener('timeupdate', timeupdate);
				}
			});
			let snapImage = function () {
				let canvas = document.createElement('canvas');
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
				let image = canvas.toDataURL();
				let success = image.length > 100000;
				if (success) {
					let img = document.createElement('img');
					img.src = image;
					parentBlock.querySelector('.media_preview').innerHTML = '';
					parentBlock.querySelector('.media_preview').appendChild(img);
					URL.revokeObjectURL(url);
				}
				return success;
			};
			video.addEventListener('timeupdate', timeupdate);
			video.preload = 'metadata';
			video.src = url;
			// Load video in Safari / IE11
			video.muted = true;
			video.playsInline = true;
			video.play();
		};
		fileReader.readAsArrayBuffer(file);
	}
}

function ChangeMediaFile(event) {
	let parentBlock = this.closest('.variant');

	let file = event.target.files[0];

	let fileReader = new FileReader();
	if (file.type.match('image')) {
		fileReader.onload = function () {
			let img = document.createElement('img');
			img.src = fileReader.result;
			parentBlock.querySelector('.media_preview').innerHTML = '';
			parentBlock.querySelector('.media_preview').appendChild(img);
		};
		fileReader.readAsDataURL(file);
	} else {
		fileReader.onload = function () {
			let blob = new Blob([fileReader.result], {type: file.type});
			let url = URL.createObjectURL(blob);
			let video = document.createElement('video');
			let timeupdate = function () {
				if (snapImage()) {
					video.removeEventListener('timeupdate', timeupdate);
					video.pause();
				}
			};
			video.addEventListener('loadeddata', function () {
				if (snapImage()) {
					video.removeEventListener('timeupdate', timeupdate);
				}
			});
			let snapImage = function () {
				let canvas = document.createElement('canvas');
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
				let image = canvas.toDataURL();
				let success = image.length > 100000;
				if (success) {
					let img = document.createElement('img');
					img.src = image;
					parentBlock.querySelector('.media_preview').innerHTML = '';
					parentBlock.querySelector('.media_preview').appendChild(img);
					URL.revokeObjectURL(url);
				}
				return success;
			};
			video.addEventListener('timeupdate', timeupdate);
			video.preload = 'metadata';
			video.src = url;
			// Load video in Safari / IE11
			video.muted = true;
			video.playsInline = true;
			video.play();
		};
		fileReader.readAsArrayBuffer(file);
	}
}

if (document.querySelector('main.choice_new')) {
	document.querySelector('form > main > input.name').addEventListener('input', () => {
		validateForm();
	})
}

function validateForm() {
	const createButton = document.querySelector('#createButton');
	const choiceName = document.querySelector('form > main > input.name');
	const countVariants = document.querySelectorAll('#variant_list .variant').length;

	createButton.disabled = !(choiceName.value !== '' && countVariants > 1);
}

function deleteVariant() {
	let parentBlock = this.closest('.variant');
	parentBlock.remove();

	const variantAddButton = document.querySelector('.variant__add');
	variantAddButton.classList.remove('hide');
}
