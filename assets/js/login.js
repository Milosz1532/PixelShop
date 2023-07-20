const loginForm = document.querySelector('.login-form')
const submit = document.querySelector('.step1-submit')
const loginInput = document.querySelector('#loginInput')

submit.addEventListener('click', e => {
	const loginValue = loginInput.value
	if (loginValue == '') {
		popupNotification('Wprowadź dane do logowania')
		return
	}
	const url = 'index.php?section=login&action=verificationLogin'
	fetch(url, {
		method: 'POST',
		body: JSON.stringify(loginValue),
	})
		.then(response => {
			if (response.ok) {
				response.json().then(data => {
					if (data.login_status == 2) {
						nextStep(data.login)
					} else if (data.login_status == 3) {
						activateAccount(data.login)
					}
				})
			} else {
				response.json().then(data => {
					popupNotification(data.error)
				})
				throw new Error('HTTP error ' + response.status)
			}
		})
		.catch(error => {
			console.log('Server error:', error.message)
		})
})

loginInput.addEventListener('keyup', function (event) {
	if (event.keyCode === 13) {
		event.preventDefault()
		submit.click()
	}
})

const passwordInput = document.querySelector('#passwordInput')
const submitPassword = document.querySelector('.step2-submit')
const nextStep = login => {
	const passwordForm = document.querySelector('.login-form.step-2')
	loginForm.classList.add('hide')
	setTimeout(function () {
		loginForm.style.display = 'none'
		passwordForm.classList.add('show')
		document.querySelector('.loginTitle > span').textContent = login
		passwordInput.focus()
		submitPassword.addEventListener('click', e => {
			const password = passwordInput.value
			if (password == '') {
				popupNotification('Wprowadź hasło do logowania')
				return
			}
			const data = { login: login, password: password }
			const url = 'index.php?section=login&action=validateAccount'
			fetch(url, {
				method: 'POST',
				body: JSON.stringify(data),
			})
				.then(response => {
					if (response.ok) {
						window.location.href = 'index.php'
					} else {
						response.json().then(data => {
							popupNotification(data.error)
						})
					}
				})
				.catch(error => {
					console.log('Server error:', error.message)
				})
		})
		const backButton = document.querySelector('#backPassword')
		backButton.addEventListener('click', e => {
			passwordForm.classList.add('hide')
			setTimeout(function () {
				loginForm.classList.remove('hide')
				loginForm.style.display = 'block'
				passwordForm.classList.remove('hide')
				passwordForm.classList.remove('show')
			}, 400)
		})
	}, 400)
}

passwordInput.addEventListener('keyup', function (event) {
	if (event.keyCode === 13) {
		event.preventDefault()
		submitPassword.click()
	}
})

const activatetBtn = document.querySelector('.activate-submit')
const activateInput = document.querySelector('#confirmActivatePassword')

const activateAccount = login => {
	const activateForm = document.querySelector('.login-form.step-3')
	loginForm.classList.add('hide')
	setTimeout(function () {
		document.querySelector('.activateTitle > span').textContent = login
		document.querySelector('#activatePassword').focus()
		loginForm.style.display = 'none'
		activateForm.classList.add('show')
		activatetBtn.addEventListener('click', e => {
			const password = document.querySelector('#activatePassword').value
			const confirmPassword = activateInput.value
			if (password == '' || confirmPassword == '') {
				popupNotification('Wypełnij wszystkie pola')
				return
			}
			if (password != confirmPassword) {
				popupNotification('Wprowadzone hasła nie są takie same')
				return
			}
			if (password.length < 8) {
				popupNotification('Hasło musi zawierać minimum 8 znaków')
				return
			}
			const data = { login: login, password: password }
			fetch('index.php?section=login&action=activateAccount', {
				// here
				method: 'POST',
				body: JSON.stringify(data),
			})
				.then(response => {
					if (response.ok) {
						popupNotification('Konto aktywowane pomyślnie. Możesz zalogować się do systemu', true)
						activateForm.classList.add('hide')
						setTimeout(function () {
							loginForm.classList.remove('hide')
							loginForm.style.display = 'block'
							activateForm.classList.remove('hide')
							activateForm.classList.remove('show')
						}, 400)
					} else {
						response.json().then(data => {
							popupNotification(data.error)
						})
					}
				})
				.catch(error => {
					console.log('Server error:', error.message)
				})
		})
		const backButton = document.querySelector('#backActivation')
		backButton.addEventListener('click', e => {
			activateForm.classList.add('hide')
			setTimeout(function () {
				loginForm.classList.remove('hide')
				loginForm.style.display = 'block'
				activateForm.classList.remove('hide')
				activateForm.classList.remove('show')
			}, 400)
		})
	}, 400)
}

activateInput.addEventListener('keyup', function (event) {
	if (event.keyCode === 13) {
		event.preventDefault()
		activatetBtn.click()
	}
})

// let timerId = null

// const loginNotification = (text, success = false) => {
// 	if (text.length === 0) return
// 	const errorBox = document.querySelector('.errorBox')
// 	const spanElement = document.querySelector('.error-message')
// 	const icon = errorBox.querySelector('.material-icons')
// 	if (success === true) {
// 		icon.textContent = 'check_circle_outline'
// 		icon.classList.add('success')
// 	} else {
// 		icon.textContent = 'error_outline'
// 	}
// 	errorBox.classList.add('active')
// 	spanElement.textContent = text
// 	clearTimeout(timerId)
// 	timerId = setTimeout(() => {
// 		removeLoginNotification()
// 	}, 5000)
// }

// const removeLoginNotification = () => {
// 	const errorBox = document.querySelector('.errorBox')
// 	const spanElement = document.querySelector('.error-message')
// 	const icon = errorBox.querySelector('.material-icons')
// 	errorBox.classList.remove('active')
// 	spanElement.textContent = ''
// 	icon.classList.remove('success')
// }
