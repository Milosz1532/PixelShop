const form = document.querySelector('#productForm')
const submitButton = document.querySelector('#submitButton')
const cancelButton = document.querySelector('#cancelButton')

if (form) {
	form.addEventListener('submit', e => {
		e.preventDefault()
	})
}

if (submitButton) {
	// Add and edit function
	submitButton.addEventListener('click', e => {
		const isEditMode = document.querySelector('#productId')
		messageText = 'Czy na pewno chcesz dodać produkt?'
		if (isEditMode) {
			messageText = 'Czy na pewno chcesz zatwierdzić zmiany?'
		}
		messageBox(messageText)
			.then(result => {
				const name = document.querySelector('#name').value
				const price = document.querySelector('#price').value
				const amount = document.querySelector('#amount').value
				const description = document.querySelector('#description').value
				const categoryId = document.querySelector('#category').value
				const taxId = document.querySelector('#tax').value
				let error = ''
				if (price <= 0) {
					error = 'Cena nie może być mniejsza lub równa 0'
				}
				if (name.length == 0 || amount < 0 || amount == '') {
					error = 'Wypełnij wszystkie wymagane pola formularza'
				}

				if (error !== '') {
					popupNotification(error)
					return
				}

				let data = {}
				let url = ''

				if (isEditMode) {
					data = { id: isEditMode.value, name, categoryId, price, amount, description, taxId }
					url = 'index.php?section=products&action=updateProductInDb' // Edit product in Database
				} else {
					data = { name, categoryId, price, amount, description, taxId }
					url = 'index.php?section=products&action=addProductToDb' // Add product to Database
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
							window.location.href = 'index.php?section=products'
							if (isEditMode) {
								localStorage.setItem(
									'showPopup',
									JSON.stringify({ message: 'Produkt został pomyślnie edytowany', success: true })
								)
							} else {
								localStorage.setItem(
									'showPopup',
									JSON.stringify({ message: 'Produkt został pomyślnie dodany', success: true })
								)
							}
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

if (cancelButton) {
	cancelButton.addEventListener('click', e => {
		messageBox('Czy na pewno chcesz zrezygnować?')
			.then(result => {
				window.location.href = 'index.php?section=products'
				// localStorage.setItem('showPopup', 'Wyświetlona wiadomość w innym oknie.')
			})
			.catch(error => {
				return
			})
	})
}

// Delete product

const deleteButtons = document.querySelectorAll('.deleteProduct')
if (deleteButtons) {
	deleteButtons.forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault()
			messageBox('Czy na pewno chcesz usunąć ten produkt?')
				.then(result => {
					const id = button.getAttribute('data-id')
					const data = { id }
					const url = 'index.php?section=products&action=deleteProductFromDb'
					fetch(url, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
						},
						body: JSON.stringify(data),
					})
						.then(response => {
							if (response.ok) {
								window.location.href = 'index.php?section=products'
								localStorage.setItem(
									'showPopup',
									JSON.stringify({ message: 'Produkt został pomyślnie usunięty', success: true })
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
	})
}

// Add category
const addButton = document.querySelector('.addCategory')
const popupWindow = document.querySelector('.popup-window')
const shadow = document.querySelector('.shadow')
const title = document.querySelector('#categoryBox-title')

const categoryBox = document.querySelector('#categoryBox')
const categorySubmit = document.querySelector('#submit')
const categoryCancel = document.querySelector('#cancel')

if (categoryBox) {
	categoryBox.addEventListener('submit', e => {
		e.preventDefault()
	})
}
if (addButton) {
	addButton.addEventListener('click', e => {
		document.querySelector('body').style.overflow = 'hidden'
		shadow.classList.add('active')
		popupWindow.classList.add('active')
		title.textContent = 'Dodaj nową kategorię'
		categorySubmit.textContent = 'Dodaj'
	})
}

if (categoryCancel) {
	categoryCancel.addEventListener('click', e => {
		document.querySelector('body').style.overflow = 'auto'
		shadow.classList.remove('active')
		popupWindow.classList.remove('active')
	})
}

if (categorySubmit) {
	categorySubmit.addEventListener('click', e => {
		if (categorySubmit.textContent != 'Dodaj') {
			return
		}
		const message = document.querySelector('#categoryText')
		if (message.value.length === 0) return
		if (document.querySelector('#hiddenInput').value != '') return
		const data = { name: message.value }

		const url = 'index.php?section=products&action=addCategoryToDb'
		fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(data),
		})
			.then(response => {
				if (response.ok) {
					window.location.href = 'index.php?section=products'
					localStorage.setItem(
						'showPopup',
						JSON.stringify({ message: 'Kategoria została pomyślnie dodana', success: true })
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
}

const editCategory = document.querySelectorAll('.editCategory')
if (editCategory) {
	editCategory.forEach(button => {
		button.addEventListener('click', e => {
			e.preventDefault()
			document.querySelector('body').style.overflow = 'hidden'
			shadow.classList.add('active')
			popupWindow.classList.add('active')
			categorySubmit.textContent = 'Edytuj'
			title.textContent = 'Edytuj kategorię'
			const message = document.querySelector('#categoryText')
			message.value = button.getAttribute('data-value')
			categorySubmit.addEventListener('click', e => {
				const id = button.getAttribute('data-id')
				const data = { id, name: message.value }
				const url = 'index.php?section=products&action=editCategoryInDb'
				fetch(url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(data),
				}).then(response => {
					if (response.ok) {
						window.location.href = 'index.php?section=products'
						localStorage.setItem(
							'showPopup',
							JSON.stringify({ message: 'Kategoria została pomyślnie edytowana', success: true })
						)
					} else {
						response.json().then(data => {
							popupNotification(data.error)
						})
					}
				})
			})
		})
	})
}

//Delete category

const deleteCategoryButtons = document.querySelectorAll('.deleteCategory')
if (deleteCategoryButtons) {
	deleteCategoryButtons.forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault()
			messageBox('Czy na pewno chcesz usunąć tą kategorie?')
				.then(result => {
					const id = button.getAttribute('data-id')
					console.log(id)
					const data = { id }
					const url = 'index.php?section=products&action=deleteCategoryFromDb'
					fetch(url, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
						},
						body: JSON.stringify(data),
					}).then(response => {
						console.log(response)
						if (response.ok) {
							window.location.href = 'index.php?section=products'
							localStorage.setItem(
								'showPopup',
								JSON.stringify({ message: 'Kategoria została pomyślnie usunięta', success: true })
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
