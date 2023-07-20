const employeeForm = document.querySelector('#employeeForm')
const cancelButton = document.querySelector('#cancelButton')
const submitButton = document.querySelector('#submitButton')

if (employeeForm) {
	employeeForm.addEventListener('submit', e => {
		e.preventDefault()
	})
}
if (cancelButton) {
	cancelButton.addEventListener('click', e => {
		window.location.href = 'index.php?section=employees'
	})
}

const inputPhoneNumber = document.querySelector('#phoneNumber')
if (inputPhoneNumber) {
	inputPhoneNumber.addEventListener('input', function () {
		this.value = this.value.replace(/[^0-9]/g, '')
	})
}

if (submitButton) {
	submitButton.addEventListener('click', e => {
		e.preventDefault()
		messageBox('Czy na pewno chcesz zatwierdzić?')
			.then(result => {
				const login = document.querySelector('#login')
				const firstName = document.querySelector('#firstName')
				const lastName = document.querySelector('#lastName')
				const email = document.querySelector('#email')
				const phoneNumber = document.querySelector('#phoneNumber')
				const birthday = document.querySelector('#birthday')
				const city = document.querySelector('#city')
				const accountType = document.querySelector('#accountType')
				let editMode = false
				if (
					login.value == '' ||
					firstName.value == '' ||
					lastName.value == '' ||
					email.value == '' ||
					phoneNumber.value == '' ||
					birthday.value == '' ||
					city.value == ''
				) {
					notification('Wypełnij wszystkie dane formularza')
					return
				}
				const data = {
					first_name: firstName.value,
					last_name: lastName.value,
					email: email.value,
					phone_number: phoneNumber.value,
					born: birthday.value,
					city: city.value,
					login: login.value,
					is_admin: accountType.checked,
				}

				if (submitButton.dataset.employeeid) {
					editMode = true
					data.id = submitButton.dataset.employeeid
				}

				let url = 'index.php?section=employees&action=addEmployeeToDb'
				if (editMode) {
					url = 'index.php?section=employees&action=updateEmployeeInDb'
				}
				fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(data),
				})
					.then(response => {
						if (response.ok) {
							window.location.href = 'index.php?section=employees'
							const infoMessage = editMode
								? 'Pracownik została pomyślnie edytowany'
								: 'Pracownik została pomyślnie dodany'
							localStorage.setItem('showPopup', JSON.stringify({ message: infoMessage, success: true }))
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
			.catch(error => {
				return
			})
	})
}

// RESET PASSWORD
const resetPasswordButton = document.querySelector('#resetPasswordButton')
if (resetPasswordButton) {
	resetPasswordButton.addEventListener('click', e => {
		const employeeId = resetPasswordButton.dataset.employeeid
		messageBox('Czy na pewno chcesz zresetować hasło?')
			.then(result => {
				const url = 'index.php?section=employees&action=resetEmployeePassword'
				fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(employeeId),
				})
					.then(response => {
						if (response.ok) {
							window.location.href = 'index.php?section=employees'
							localStorage.setItem(
								'showPopup',
								JSON.stringify({ message: 'Hasło pracownika zostało pomyślnie zresetowane', success: true })
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
			})
			.catch(error => {
				return
			})
	})
}

// DELETE
const deleteAccount = document.querySelector('#deleteAccount')
if (deleteAccount) {
	deleteAccount.addEventListener('click', e => {
		const employeeId = deleteAccount.dataset.employeeid
		messageBox('Czy na pewno chcesz usunąć to konto?')
			.then(result => {
				const url = 'index.php?section=employees&action=deleteEmployeeFromDb'
				fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(employeeId),
				})
					.then(response => {
						if (response.ok) {
							window.location.href = 'index.php?section=employees'
							localStorage.setItem(
								'showPopup',
								JSON.stringify({ message: 'Pracownik został pomyślnie usunięty', success: true })
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
			})
			.catch(error => {
				return
			})
	})
}
