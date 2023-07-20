const searchInput = document.querySelector('.search.all-orders input')
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

const searchProduct = document.querySelector('.search.product input')
const productTableRows = document.querySelectorAll('.table.products-table tbody tr')

if (searchProduct) {
	searchProduct.addEventListener('input', function () {
		const searchText = this.value.trim().toLowerCase()

		productTableRows.forEach(row => {
			const cells = Array.from(row.cells).slice(0, -1)
			const text = cells.map(cell => cell.textContent.trim().toLowerCase()).join(' ')
			const match = text.includes(searchText)
			row.style.display = match ? 'table-row' : 'none'
		})
	})
}

const searchClient = document.querySelector('.search.client input')
const clientTableRows = document.querySelectorAll('.table.clients-table tbody tr')

if (searchClient) {
	searchClient.addEventListener('input', function () {
		const searchText = this.value.trim().toLowerCase()

		clientTableRows.forEach(row => {
			const text = row.textContent.trim().toLowerCase()
			const match = text.includes(searchText)
			row.style.display = match ? 'table-row' : 'none'
		})
	})
}

const rows = document.querySelectorAll('tr.product-row')

if (rows) {
	rows.forEach(function (row) {
		const checkbox = row.querySelector("input[type='checkbox']")

		row.addEventListener('click', function (event) {
			if (event.target.type === 'number' || event.target.type == 'select-one') {
				return
			}

			checkbox.checked = !checkbox.checked

			const quantityCell = row.querySelector('.quantity-cell input')
			const taxCell = row.querySelector('.tax-cell select')
			if (checkbox.checked) {
				quantityCell.value = 1
				quantityCell.style.display = 'table-cell'
				taxCell.style.display = 'table-cell'
				updateTotalCost()
			} else {
				quantityCell.value = 0
				updateTotalCost()
				quantityCell.style.display = 'none'
				taxCell.style.display = 'none'
			}
		})

		if (checkbox) {
			checkbox.addEventListener('change', function () {
				const quantityCell = row.querySelector('.quantity-cell input')
				if (checkbox.checked) {
					quantityCell.value = 1
					updateTotalCost()
					quantityCell.style.display = 'table-cell'
				} else {
					quantityCell.value = 0
					updateTotalCost()
					quantityCell.style.display = 'none'
				}
			})
		}
	})
}

const total_address = document.querySelector('#total_address')
const total_city = document.querySelector('#total_city')
const total_zip_code = document.querySelector('#total_zip_code')
const total_nip = document.querySelector('#total_nip')
const total_info = document.querySelector('.total-info')

const getClientAddress = id => {
	return fetch('index.php?section=orders&action=getClientAddress', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
		body: JSON.stringify({ id }),
	})
		.then(response => response.json())
		.then(data => {
			if (data.address) {
				total_address.value = data.address
				total_city.value = data.city
				total_zip_code.value = data.zip_code
				total_nip.value = data.nip

				total_info.textContent =
					'* Dane adresowe zostały wprowadzone automatycznie z poprzedniego zamówienia tego klienta'
			} else {
				total_address.value = ''
				total_city.value = ''
				total_zip_code.value = ''
				total_nip.value = ''
				total_info.textContent = ''
			}
		})
}

const clientRows = document.querySelectorAll('.select-client')

if (clientRows) {
	clientRows.forEach(function (row) {
		row.addEventListener('click', function () {
			const selectedRows = document.querySelectorAll('.select-client.selected')
			selectedRows.forEach(function (selectedRow) {
				selectedRow.classList.remove('selected')
			})

			row.classList.add('selected')
			const bottomFormName = document.querySelector('#clientName')
			bottomFormName.value =
				row.querySelector('.client_first_name').textContent + ' ' + row.querySelector('.client_last_name').textContent
			getClientAddress(row.dataset.clientId)
		})
	})
}

const tax = document.querySelector('#selectTax')
if (tax) {
	tax.addEventListener('change', e => {
		updateTotalCost()
	})
}

const calculateTotalCost = () => {
	let totalCost = 0
	checkboxes.forEach(checkbox => {
		if (checkbox.checked) {
			const productRow = checkbox.closest('.product-row')
			const selectedOption = document.querySelector('#selectTax option:checked')
			// const selectedTax = selectedOption.dataset.tax
			const price = parseFloat(productRow.querySelector('td:nth-child(4)').textContent)
			const quantity = parseInt(productRow.querySelector('.quantity-cell input').value)

			var productTaxData = productRow.querySelector('.tax-cell .selectTax')
			var selected_option = productTaxData.options[productTaxData.selectedIndex]
			var productTax = selected_option.getAttribute('data-tax')

			if (productTax != 0) {
				totalCost += price * quantity * productTax
			} else {
				totalCost += price * quantity
			}
		}
	})
	return totalCost
}

const checkboxes = document.querySelectorAll('input[type="checkbox"]')
const totalCostInput = document.querySelector('#totalCost')

function updateTotalCost() {
	totalCostInput.value = calculateTotalCost().toFixed(2)
}

const quantityInputs = document.querySelectorAll('.quantity-cell input')

if (quantityInputs) {
	quantityInputs.forEach(input => {
		input.addEventListener('change', e => {
			const inputValue = parseInt(input.value)
			const minValue = 1
			const maxValue = parseInt(input.max)
			if (inputValue > maxValue) {
				input.value = maxValue
				return
			}
			if (inputValue < minValue) {
				input.value = minValue
				return
			}
			updateTotalCost()
		})
	})
}

const taxInputs = document.querySelectorAll('.tax-cell .selectTax')
if (taxInputs) {
	taxInputs.forEach(input => {
		input.addEventListener('change', e => {
			updateTotalCost()
		})
	})
}

const submitButton = document.querySelector('.submit-button')
const cancelButton = document.querySelector('.cancel-button')

if (cancelButton) {
	cancelButton.addEventListener('click', e => {
		messageBox('Czy na pewno opuścić kreator zamówienia?')
			.then(result => {
				window.location.href = 'index.php?section=orders'
			})
			.catch(error => {
				return
			})
	})
}

if (submitButton) {
	submitButton.addEventListener('click', function () {
		messageBox('Czy na pewno chcesz stworzyć to zamówienie?').then(result => {
			let order = []

			const selectedRow = document.querySelector('.select-client.selected')
			if (selectedRow) {
				const clientId = selectedRow.dataset.clientId
				let employeeId = document.querySelector('#employeeId').value
				if (employeeId < 0) {
					employeeId = 0
				}
				order.push({ clientId: clientId, employeeId: employeeId })
			} else {
				popupNotification('Wybierz klienta z listy')
				return
			}

			let addressInput = document.querySelector('#total_address').value
			let cityInput = document.querySelector('#total_city').value
			let zipCodeInput = document.querySelector('#total_zip_code').value
			let commentsInput = document.querySelector('#total_comments').value
			let nipInput = document.querySelector('#total_nip').value
			const selectedOption = document.querySelector('#selectTax option:checked')
			// const selectedTax = selectedOption.value

			if (addressInput == '' || cityInput == '' || zipCodeInput == '') {
				popupNotification('Proszę wprowadzić adres dostawy')
				return
			}

			order.push({
				address: addressInput,
				city: cityInput,
				zip_code: zipCodeInput,
				// tax: selectedTax,
				comments: commentsInput,
				nip: nipInput,
			})

			const rows = document.getElementsByClassName('product-row')
			let hasProduct = false
			for (let i = 0; i < rows.length; i++) {
				let checkbox = rows[i].querySelector('input[type="checkbox"]')

				if (checkbox.checked) {
					let quantityInput = rows[i].querySelector('.quantity-cell input[type="number"]')
					let quantity = quantityInput.value
					let productPrice = rows[i].querySelector('.price-cell').textContent
					if (quantity <= 0) {
						popupNotification('Ilość produktów nie może być mniejsza lub równa 0')
						return
					}

					let productId = checkbox.id.replace('customCheck', '')
					let taxId = rows[i].querySelector('.tax-cell .selectTax').value

					order.push({ productId, quantity: quantity, productPrice: productPrice, taxId })
					hasProduct = true
				}
			}

			if (!hasProduct) {
				popupNotification('Wybierz co najmniej jeden produkt')
				return
			}

			fetch('index.php?section=orders&action=addOrderToDb', {
				method: 'POST',
				body: JSON.stringify(order),
			})
				.then(response => {
					if (response.ok) {
						window.location.href = 'index.php?section=orders'
						localStorage.setItem(
							'showPopup',
							JSON.stringify({ message: 'Zamówienie zostało pomyślnie utworzone', success: true })
						)
					} else {
						response.json().then(data => {
							console.log('HTTP error ' + response.status + ': ' + data.error)
							notification(data.error)
						})
						throw new Error('HTTP error ' + response.status)
					}
				})
				.catch(error => {
					console.log('Server error:', error.message)
				})
		})
	})
}

// Change status
const changeStatus = document.querySelectorAll('.medium-col-buttons > .buttons > .button-tooltip > a')
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
								window.location.href = 'index.php?section=orders'
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

//Add Client
const addClientButton = document.querySelector('.addClient-button')
if (addClientButton) {
	addClientButton.addEventListener('click', e => {
		//box
		const clientBox = document.querySelector('.add-user-box')
		const shadow = document.querySelector('.shadow')
		clientBox.classList.add('active')
		shadow.classList.add('active')
		document.body.classList.add('no-scroll')

		//buttons and inputs
		const firstName = clientBox.querySelector('#first_name')
		const lastName = clientBox.querySelector('#last_name')
		const phoneNumber = clientBox.querySelector('#phone_number')

		const submitBtn = clientBox.querySelector('#cb-submit')
		const cancelBtn = clientBox.querySelector('#cb-cancel')

		const hideWindow = e => {
			clientBox.classList.remove('active')
			shadow.classList.remove('active')
			document.body.classList.remove('no-scroll')
			cancelBtn.removeEventListener('click', hideWindow)
			submitBtn.removeEventListener('click', submitUserData)
		}
		cancelBtn.addEventListener('click', hideWindow)

		const submitUserData = e => {
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
				// clientBox.querySelector('.cb-info').textContent = error
				popupNotification(error)
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
			})
				.then(response => {
					if (response.ok) {
						response.json().then(data => {
							const tableBody = document.querySelector('.clients-table tbody')
							const newRow = tableBody.insertRow()
							newRow.classList.add('select-client')
							newRow.classList.add('selected')
							const clientID = data[0]
							newRow.setAttribute('data-client-id', clientID)

							newRow.innerHTML = `
							            <th scope="row">${clientID}</th>
							            <td class="client_first_name">${firstName.value}</td>
							            <td class="client_last_name">${lastName.value}</td>
							            <td class="client_phone_number">${phoneNumber.value}</td>
							        `
							const bottomFormName = document.querySelector('#clientName')
							bottomFormName.value = firstName.value + ' ' + lastName.value
							clientBox.classList.remove('active')
							shadow.classList.remove('active')
							document.body.classList.remove('no-scroll')
							popupNotification('Nowy klient został dodany.', true)
							firstName.value = ''
							lastName.value = ''
							phoneNumber.value = ''
						})
					} else {
						response.json().then(data => {
							// clientBox.querySelector('.cb-info').textContent = data.error
							popupNotification(data.error)
						})
					}
				})
				.catch(error => {})
		}
		submitBtn.addEventListener('click', submitUserData)
	})
}

const orderRow = document.querySelectorAll('tr.order-row')

if (orderRow) {
	orderRow.forEach(row => {
		row.addEventListener('click', e => {
			if (
				e.target.closest('.button-tooltip') ||
				e.target.closest('.buttons') ||
				e.target.closest('.medium-col-buttons')
			) {
				return
			}
			window.location.href = 'index.php?section=orders&action=previewForm&id=' + row.dataset.id
		})
	})
}
