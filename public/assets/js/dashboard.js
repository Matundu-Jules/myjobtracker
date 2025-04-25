const statusOptions = [
    { value: 'not_sent', label: 'Non envoyée' },
    { value: 'sent', label: 'Envoyée' },
    { value: 'pending', label: 'En attente de réponse' },
    { value: 'rejected', label: 'Rejetée' },
    { value: 'interview', label: 'Entretien' },
    { value: 'offer', label: 'Offre reçue' },
]

// Toast message for errors and notifications
function showToast(message, type = 'error') {
    const toast = document.getElementById('toast')
    if (!toast) return

    toast.textContent = message
    toast.className = `toast ${type} show`

    setTimeout(() => {
        toast.classList.remove('show')
        setTimeout(() => (toast.className = `toast ${type} hidden`), 300)
    }, 3000)
}

//
function isDateConsistencyValid(field, appDate, repDate) {
    if (!appDate || !repDate) return true

    const app = new Date(appDate)
    const rep = new Date(repDate)

    if (field === 'reply_date') {
        return rep >= app
    } else if (field === 'application_date') {
        return app <= rep
    }
    return true
}

// Search
document.getElementById('searchInput')?.addEventListener('keyup', function () {
    const filter = this.value.toLowerCase()
    document.querySelectorAll('#applicationsTable tbody tr').forEach((row) => {
        row.style.display = row.textContent.toLowerCase().includes(filter)
            ? ''
            : 'none'
    })
})

// Sort
function sortTable(colIndex) {
    const table = document.getElementById('applicationsTable')
    const rows = Array.from(table.rows).slice(1)
    const ascending = table.getAttribute('data-sort-dir') !== 'asc'
    rows.sort((a, b) => {
        const valA = a.cells[colIndex].textContent.trim().toLowerCase()
        const valB = b.cells[colIndex].textContent.trim().toLowerCase()
        return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA)
    })
    rows.forEach((row) => table.tBodies[0].appendChild(row))
    table.setAttribute('data-sort-dir', ascending ? 'asc' : 'desc')
}
window.sortTable = sortTable

// Inline editing
document.querySelectorAll('td.editable').forEach((cell) => {
    cell.addEventListener('dblclick', function () {
        if (this.querySelector('input') || this.querySelector('select')) return

        const originalValue = this.innerText.trim()
        const id = this.dataset.id
        const field = this.dataset.field
        let input

        if (field === 'application_status') {
            input = document.createElement('select')
            input.className = 'inline-input'
            statusOptions.forEach((opt) => {
                const option = document.createElement('option')
                option.value = opt.value
                option.textContent = opt.label
                if (opt.label === originalValue || opt.value === originalValue)
                    option.selected = true
                input.appendChild(option)
            })
        } else {
            input = document.createElement('input')
            input.type = field.includes('date')
                ? 'date'
                : field === 'offer_link'
                ? 'url'
                : 'text'
            input.value = originalValue
            input.className = 'inline-input'
        }

        this.innerHTML = ''
        this.appendChild(input)
        input.focus()

        const saveChange = () => {
            const newValue = input.value.trim()
            if (newValue === originalValue || newValue === '') {
                cell.innerHTML = originalValue
                return
            }

            if (field === 'reply_date' || field === 'application_date') {
                const row = cell.closest('tr')
                const appCell = row.querySelector(
                    '[data-field="application_date"]'
                )
                const repCell = row.querySelector('[data-field="reply_date"]')

                let appValue = appCell?.textContent.trim()
                let repValue = repCell?.textContent.trim()

                if (appValue?.includes('/'))
                    appValue = appValue.split('/').reverse().join('-')
                if (repValue?.includes('/'))
                    repValue = repValue.split('/').reverse().join('-')

                const appDate =
                    field === 'application_date' ? newValue : appValue
                const repDate = field === 'reply_date' ? newValue : repValue

                if (!isDateConsistencyValid(field, appDate, repDate)) {
                    showToast(
                        "⚠️ La date d'envoi ne peut pas être après la date de réponse (et inversement)."
                    )
                    cell.innerHTML = originalValue
                    return
                }
            }

            fetch('/update_application.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, field, value: newValue }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        if (field === 'offer_link') {
                            setTimeout(() => {
                                const a = document.createElement('a')
                                a.href = newValue
                                a.target = '_blank'
                                a.textContent = newValue
                                a.style.cssText =
                                    'display:inline-block; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;'
                                const wrapper = document.createElement('span')
                                wrapper.className = 'editable-link'
                                wrapper.title = 'Double-cliquez pour modifier'
                                wrapper.appendChild(a)
                                cell.innerHTML = ''
                                cell.appendChild(wrapper)
                                showToast(
                                    '✅ Modification enregistrée',
                                    'success'
                                )
                            }, 10)
                        } else if (field === 'application_status') {
                            const label =
                                statusOptions.find(
                                    (opt) => opt.value === newValue
                                )?.label || newValue
                            cell.innerHTML = label
                            showToast('✅ Modification enregistrée', 'success')
                        } else if (
                            field === 'application_date' ||
                            field === 'reply_date'
                        ) {
                            const parts = newValue.split('-') // yyyy-mm-dd
                            const formatted = `${parts[2]}/${parts[1]}/${parts[0]}` // dd/mm/yyyy
                            cell.innerHTML = formatted
                            showToast('✅ Modification enregistrée', 'success')
                        } else {
                            cell.innerHTML = newValue
                            showToast('✅ Modification enregistrée', 'success')
                        }
                    } else {
                        showToast(`Erreur: ${data.message}`)
                        cell.innerHTML = originalValue
                    }
                })
                .catch(() => {
                    showToast('Erreur de communication serveur.')
                    cell.innerHTML = originalValue
                })
        }

        input.addEventListener('blur', () => setTimeout(saveChange, 10))
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault()
                saveChange()
            }
        })
    })
})
