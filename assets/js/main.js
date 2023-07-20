// POPUP NOTIFICATION //
window.addEventListener('load', () => {
	const popUp = localStorage.getItem('showPopup')
	if (popUp) {
		console.log(`first`)

		const { message, success } = JSON.parse(popUp)
		popupNotification(message, success)
		localStorage.removeItem('showPopup')
	}
})

// NAVIGATION MODE //

const navigaion = document.querySelector('nav')
const navButton = document.querySelector('.toggle-nav')
const main = document.querySelector('main')

if (navigaion) {
	if (localStorage.getItem('navActive')) {
		navigaion.classList.add('active', 'localStorage')
		main.classList.add('active', 'localStorage')
	}

	navButton.addEventListener('click', e => {
		navigaion.classList.toggle('active')
		main.classList.toggle('active')
		if (navigaion.classList.contains('active')) {
			localStorage.setItem('navActive', true)
		} else {
			localStorage.removeItem('navActive')
			if (navigaion.classList.contains('localStorage')) {
				navigaion.classList.remove('localStorage')
				main.classList.remove('localStorage')
			}
		}
	})
}

const currentUrl = window.location.href
const urlParams = new URLSearchParams(window.location.search)
const section = urlParams.get('section')
const filename = currentUrl.substring(currentUrl.lastIndexOf('/') + 1)

if (filename == '') {
	const newUrl = currentUrl + 'index.php'
	window.location.href = newUrl
}

const navLinks = document.querySelectorAll('nav ul li > a')
navLinks.forEach(link => {
	if (section && link.href.includes(section)) {
		link.parentElement.classList.add('active')
	} else if (!section && link.href === currentUrl) {
		link.parentElement.classList.add('active')
	}
})

// MESSAGE BOX

const messageBox = text => {
	const overlay = document.createElement('div')
	overlay.classList.add('overlay')

	let messageBox = document.createElement('div')
	messageBox.classList.add('messageBox')
	messageBox.innerHTML = `<h4>${text}</h4>`

	let buttons = document.createElement('div')
	buttons.classList.add('buttons')

	let cancelButton = document.createElement('button')
	cancelButton.innerHTML = 'Anuluj'
	cancelButton.addEventListener('click', function () {
		messageBox.parentNode.removeChild(messageBox)
		overlay.parentNode.removeChild(overlay)
		error('Anulowano')
		document.body.classList.remove('no-scroll')
	})
	buttons.appendChild(cancelButton)

	let confirmButton = document.createElement('button')
	confirmButton.innerHTML = 'OK'
	confirmButton.addEventListener('click', function () {
		messageBox.parentNode.removeChild(messageBox)
		overlay.parentNode.removeChild(overlay)
		document.body.classList.remove('no-scroll')
		success('OK')
	})
	buttons.appendChild(confirmButton)

	messageBox.appendChild(buttons)
	document.body.appendChild(messageBox)
	document.body.appendChild(overlay)
	document.body.classList.add('no-scroll')

	return new Promise((resolve, reject) => {
		success = resolve
		error = reject
	})
}

const notification = (text, success = false) => {
	if (text.lenght === 0) return
	const errorBox = document.querySelector('.errorBox')
	const spanElement = document.querySelector('.error-message')
	const icon = errorBox.querySelector('.material-icons')
	if (success === true) {
		icon.textContent = 'check_circle_outline'
		icon.classList.add('success')
	} else {
		icon.textContent = 'error_outline'
	}
	errorBox.classList.add('active')
	spanElement.textContent = text

	setTimeout(() => {
		errorBox.classList.remove('active')
		spanElement.textContent = ''
		icon.classList.remove('success')
	}, 5000)
}

let timerId = null

const popupNotification = (text, success = false) => {
	if (text.lenght === 0) return
	const notificationBox = document.querySelector('.popup-notification')
	const notificationTitle = notificationBox.querySelector('.title')
	const notificationMessage = notificationBox.querySelector('.content > .message')
	const notificationIcon = notificationBox.querySelector('.content > i')
	if (success === true) {
		notificationIcon.className = 'fa-solid fa-check'
		notificationTitle.textContent = 'Gratulacje'
		notificationIcon.style.color = 'green'
	} else {
		notificationIcon.className = 'fa-solid fa-triangle-exclamation'
		notificationTitle.textContent = 'Wystąpił błąd'
		notificationIcon.style.color = 'tomato'
	}
	notificationBox.classList.add('active')
	notificationMessage.textContent = text

	clearTimeout(timerId)
	timerId = setTimeout(() => {
		notificationBox.classList.remove('active')
		notificationMessage.textContent = ''
	}, 5000)
}
