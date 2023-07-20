// Messages
const addButton = document.querySelector('.add-message')
const popupWindow = document.querySelector('.popup-window')
const shadow = document.querySelector('.shadow')

const submitButton = document.querySelector('#submit')
const cancelButton = document.querySelector('#cancel')

if (addButton) {
	addButton.addEventListener('click', e => {
		document.querySelector('body').style.overflow = 'hidden'
		shadow.classList.add('active')
		popupWindow.classList.add('active')
	})
}

const closeWindow = e => {
	document.querySelector('body').style.overflow = 'auto'
	shadow.classList.remove('active')
	popupWindow.classList.remove('active')
	submitButton.removeEventListener('click', submitMessage)
	cancelButton.removeEventListener('click', closeWindow)
}
cancelButton.addEventListener('click', closeWindow)

const submitMessage = e => {
	const message = document.querySelector('#messageForm-message')
	if (message.value.length === 0) return
	console.log(`Klik`)

	const employee_id = document.querySelector('#messageForm-employee-id').value

	const data = { message: message.value, employee_id }

	const url = 'index.php?section=dashboard&action=addAnnouncementToDb'
	fetch(url, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify(data),
	})
		.then(response => {
			if (response.ok) {
				window.location.reload()
				localStorage.setItem(
					'showPopup',
					JSON.stringify({ message: 'Wiadomość została pomyślnie utworzona', success: true })
				)
			} else {
				response.json().then(data => {
					popupNotification(data.error)
				})
			}
		})
		.catch(error => {
			console.log('Server error:', error.message)
		})

	//
}

submitButton.addEventListener('click', submitMessage)
