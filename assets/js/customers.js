const searchInput = document.querySelector('.search input')
const tableRows = document.querySelectorAll('.table tbody tr')

if (searchInput) {
	searchInput.addEventListener('input', function () {
		const searchText = this.value.trim().toLowerCase()

		tableRows.forEach(row => {
			const cells = Array.from(row.cells).slice(0, -1)
			const text = cells.map(cell => cell.textContent.trim().toLowerCase()).join(' ')
			const match = text.includes(searchText)
			row.style.display = match ? 'table-row' : 'none'
		})
	})
}

const inputPhoneNumber = document.getElementById('phone_number')
if (inputPhoneNumber) {
	inputPhoneNumber.addEventListener('input', function () {
		this.value = this.value.replace(/[^0-9]/g, '')
	})
}
//Add Client
const addClientButton = document.querySelector('.addCustomer')
if (addClientButton) {
	addClientButton.addEventListener('click', e => {
		//box
		const clientBox = document.querySelector('.add-user-box')
		const shadow = document.querySelector('.shadow')
		clientBox.classList.add('active')
		shadow.classList.add('active')
		document.body.classList.add('no-scroll')
		clientBox.querySelector('.title').textContent = 'Dodawanie klienta'

		//buttons and inputs
		const firstName = clientBox.querySelector('#first_name')
		const lastName = clientBox.querySelector('#last_name')
		const phoneNumber = clientBox.querySelector('#phone_number')
		firstName.value = ''
		lastName.value = ''
		phoneNumber.value = ''

		const submitBtn = clientBox.querySelector('#cb-submit')
		const cancelBtn = clientBox.querySelector('#cb-cancel')
		submitBtn.textContent = 'Dodaj'

		const CloseWindow = e => {
			clientBox.classList.remove('active')
			shadow.classList.remove('active')
			document.body.classList.remove('no-scroll')
			submitBtn.removeEventListener('click', AddClientToDB)
			cancelBtn.removeEventListener('click', CloseWindow)
		}
		cancelBtn.addEventListener('click', CloseWindow)

		const AddClientToDB = e => {
			if (submitBtn.textContent != 'Dodaj') return
			let error = ''
			if (!phoneNumber.value.match(/^\d+$/)) {
				error = 'Numer telefonu jest nieprawidłowy'
			}
			if (phoneNumber.value.length < 9) {
				error = 'Numer telefonu jest zbyt krótki'
			}
			if (firstName.value == '' && lastName.value == '' && phoneNumber.value == '') {
				error = 'Wypełnij wszystkie pola'
			}
			if (error != '') {
				clientBox.querySelector('.cb-info').textContent = error
				return
			}
			let client = []
			client.push({
				first_name: firstName.value,
				last_name: lastName.value,
				phone_number: phoneNumber.value,
			})
			fetch('index.php?section=customers&action=addCustomerToDb', {
				method: 'POST',
				body: JSON.stringify(client),
			}).then(response => {
				if (response.ok) {
					window.location.href = 'index.php?section=customers'
					localStorage.setItem(
						'showPopup',
						JSON.stringify({ message: 'Klient został pomyślnie dodany', success: true })
					)
				} else {
					response.json().then(data => {
						popupNotification(data.error)
					})
				}
			})
		}
		submitBtn.addEventListener('click', AddClientToDB)
	})
}

const deleteCustomers = document.querySelectorAll('.deleteCustomer')
if (deleteCustomers) {
	deleteCustomers.forEach(button => {
		button.addEventListener('click', e => {
			e.preventDefault()
			messageBox('Czy na pewno usunąć tego klienta?')
				.then(result => {
					const id = button.dataset.id

					fetch('index.php?section=customers&action=deleteCustomerFromDb', {
						method: 'POST',
						body: JSON.stringify(id),
					}).then(response => {
						if (response.ok) {
							window.location.href = 'index.php?section=customers'
							localStorage.setItem(
								'showPopup',
								JSON.stringify({ message: 'Klient został pomyślnie usunięty', success: true })
							)
						} else {
							response.json().then(data => {
								popupNotification(data.error)
							})
						}
					})
				})
				.catch(error => {
					return
				})
		})
	})
}

const editCustomers = document.querySelectorAll('.editCustomer')
if (editCustomers) {
	editCustomers.forEach(button => {
		button.addEventListener('click', e => {
			//box
			const clientBox = document.querySelector('.add-user-box')
			const shadow = document.querySelector('.shadow')
			clientBox.classList.add('active')
			shadow.classList.add('active')
			document.body.classList.add('no-scroll')
			clientBox.querySelector('.title').textContent = 'Edytuj klienta'

			//buttons and inputs
			const firstName = clientBox.querySelector('#first_name')
			const lastName = clientBox.querySelector('#last_name')
			const phoneNumber = clientBox.querySelector('#phone_number')
			firstName.value = button.dataset.firstName
			lastName.value = button.dataset.lastName
			phoneNumber.value = button.dataset.phoneNumber

			const submitBtn = clientBox.querySelector('#cb-submit')
			submitBtn.textContent = 'Edytuj'
			const cancelBtn = clientBox.querySelector('#cb-cancel')

			const CloseWindow = e => {
				clientBox.classList.remove('active')
				shadow.classList.remove('active')
				document.body.classList.remove('no-scroll')
				submitBtn.removeEventListener('click', UpdateClientInDb)
				cancelBtn.removeEventListener('click', CloseWindow)
			}
			cancelBtn.addEventListener('click', CloseWindow)

			const UpdateClientInDb = e => {
				if (submitBtn.textContent != 'Edytuj') return
				let error = ''
				if (!phoneNumber.value.match(/^\d+$/)) {
					error = 'Numer telefonu jest nieprawidłowy'
				}
				if (phoneNumber.value.length < 9) {
					error = 'Numer telefonu jest zbyt krótki'
				}
				if (firstName.value == '' && lastName.value == '' && phoneNumber.value == '') {
					error = 'Wypełnij wszystkie pola'
				}
				if (error != '') {
					clientBox.querySelector('.cb-info').textContent = error
					return
				}
				let client = []
				client.push({
					client_id: button.dataset.id,
					first_name: firstName.value,
					last_name: lastName.value,
					phone_number: phoneNumber.value,
				})
				fetch('index.php?section=customers&action=updateCustomerInDb', {
					method: 'POST',
					body: JSON.stringify(client),
				}).then(response => {
					if (response.ok) {
						window.location.href = 'index.php?section=customers'
						localStorage.setItem(
							'showPopup',
							JSON.stringify({ message: 'Dane klienta zostały pomyślnie edytowane', success: true })
						)
					} else {
						response.json().then(data => {
							popupNotification(data.error)
						})
					}
				})
			}
			submitBtn.addEventListener('click', UpdateClientInDb)

			submitBtn.addEventListener('click', e => {
				let error = ''
				if (submitBtn.textContent != 'Edytuj') return
			})
		})
	})
}

const customerRow = document.querySelectorAll('tr.customer-row')

if (customerRow) {
	customerRow.forEach(row => {
		row.addEventListener('click', e => {
			if (e.target.closest('.buttons') || e.target.closest('.medium-col-buttons') || e.target.closest('.td-buttons')) {
				return
			}
			const customerId = row.dataset.id
			window.location.href = 'index.php?section=customers&action=previewCustomer&id=' + customerId
		})
	})
}

const customerOrderRow = document.querySelectorAll('tr.customerOrder-row')

if (customerOrderRow) {
	customerOrderRow.forEach(row => {
		row.addEventListener('click', e => {
			const orderId = row.dataset.id
			window.location.href = 'index.php?section=orders&action=previewForm&id=' + orderId
		})
	})
}

// Change status
const changeStatus = document.querySelectorAll('.medium-col-buttons > .status-buttons > .button-tooltip > a')
if (changeStatus) {
	changeStatus.forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault()
			messageBox('Czy na pewno zmienić status tego zamówienia?')
				.then(result => {
					const orderId = button.getAttribute('data-order')
					const statusId = button.getAttribute('data-status')
					const data = { orderId, statusId }
					fetch('index.php?section=orders&action=changeOrderStatus', {
						method: 'POST',
						body: JSON.stringify(data),
					})
						.then(response => {
							if (response.ok) {
								window.location.reload()
								localStorage.setItem(
									'showPopup',
									JSON.stringify({ message: 'Status zamówienia został pomyślnie zmieniony', success: true })
								)
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
				.catch(error => {
					return
				})
		})
	})
}
