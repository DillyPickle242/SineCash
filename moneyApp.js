//SEND PAGE - div-based radio selection
const sendDoneButton = document.getElementById("sendDoneButton")
const sendForm = document.getElementById("sendForm")
if (sendDoneButton && sendForm) {
    const sendPersonList = document.getElementById("sendPersonList")
    let sendConfirmed = false

    const getSendPersonDivs = () => Array.from(sendPersonList.querySelectorAll('.sendPersonItem'))

    sendPersonList.addEventListener('click', (event) => {
        const clickedDiv = event.target.closest('.sendPersonItem')
        if (!clickedDiv) return

        getSendPersonDivs().forEach(div => div.classList.remove('selected'))
        clickedDiv.classList.add('selected')
    })

    sendForm.addEventListener('submit', (event) => {
        if (sendConfirmed) {
            sendConfirmed = false
            return
        }

        event.preventDefault()
        const amountValue = document.getElementById('sendCashAmount').value
        const noteValue = document.getElementById('sendNote').value
        const selectedDiv = sendPersonList.querySelector('.sendPersonItem.selected')

        if (amountValue && noteValue) {
            if (selectedDiv) {
                const selectedName = selectedDiv.textContent.trim()
                const selectedValue = selectedDiv.getAttribute('data-value')
                document.getElementById("confirmation").classList.remove("hidden")
                document.getElementById('sendConfirm').innerHTML = "Are you sure you'd like to send $" + amountValue + " to " + selectedName + " for " + noteValue + "?"
            } else {
                alert("Please select who you'd like to send to")
            }
        } else {
            alert("Please fill in ALL fields or check that you only inputted numbers in the money field")
        }
    })

    document.getElementById("sendConfirmYes").addEventListener('click', (event) => {
        event.preventDefault()
        const selectedDiv = sendPersonList.querySelector('.sendPersonItem.selected')
        if (selectedDiv) {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'sendPersonSelect'
            input.value = selectedDiv.getAttribute('data-value')
            sendForm.appendChild(input)
        }
        sendConfirmed = true
        document.getElementById("confirmation").classList.add("hidden")
        sendForm.submit()
    })

    document.getElementById("sendConfirmNo").addEventListener('click', (event) => {
        event.preventDefault()
        sendConfirmed = false
        document.getElementById("confirmation").classList.add("hidden")
    })
}

//REQUEST PAGE - div-based checkbox selection
const requestDoneButton = document.getElementById("requestDoneButton")
const requestForm = document.getElementById("requestForm")
if (requestDoneButton && requestForm) {
    const requestSelectAllDiv = document.getElementById("requestSelectAll")
    const requestPersonList = document.getElementById("requestPersonList")
    let requestConfirmed = false

    const getRequestPersonDivs = () => Array.from(requestPersonList.querySelectorAll('.requestPersonItem'))

    const updateSelectAllState = () => {
        if (!requestSelectAllDiv) return
        const divs = getRequestPersonDivs()
        const allSelected = divs.length > 0 && divs.every(div => div.classList.contains('selected'))
        requestSelectAllDiv.classList.toggle('selected', allSelected)
    }

    const splitSummary = document.getElementById('splitSummary')

    const updateSplitSummary = () => {
        const amountValue = parseFloat(document.getElementById('requestCashAmount').value)
        const selected = getRequestPersonDivs().filter(div => div.classList.contains('selected'))
        const count = selected.length

        if (count === 0) {
            splitSummary.textContent = 'Choose people to request from and the amount will be split evenly.'
            return
        }

        if (!amountValue || amountValue <= 0) {
            splitSummary.textContent = 'Selected ' + count + ' person' + (count === 1 ? '' : 's') + '. Enter an amount to see each share.'
            return
        }

        const splitAmount = (amountValue / count).toFixed(2)
        splitSummary.textContent = 'Split evenly among ' + count + ' ' + (count === 1 ? 'person' : 'people') + ': $' + splitAmount + ' each.'
    }

    if (requestSelectAllDiv) {
        requestSelectAllDiv.addEventListener('click', () => {
            requestSelectAllDiv.classList.toggle('selected')
            const shouldSelect = requestSelectAllDiv.classList.contains('selected')
            getRequestPersonDivs().forEach(div => {
                div.classList.toggle('selected', shouldSelect)
            })
            updateSplitSummary()
        })
    }

    requestPersonList.addEventListener('click', (event) => {
        const clickedDiv = event.target.closest('.requestPersonItem')
        if (!clickedDiv) return

        clickedDiv.classList.toggle('selected')
        updateSelectAllState()
        updateSplitSummary()
    })

    document.getElementById('requestCashAmount').addEventListener('input', updateSplitSummary)

    requestForm.addEventListener('submit', (event) => {
        if (requestConfirmed) {
            requestConfirmed = false
            return
        }

        event.preventDefault()
        const amountValue = document.getElementById('requestCashAmount').value
        const noteValue = document.getElementById('requestNote').value
        const selected = getRequestPersonDivs().filter(div => div.classList.contains('selected'))

        if (amountValue && noteValue) {
            if (selected.length > 0) {
                const selectedNames = selected.map(div => div.textContent.trim()).join(', ')
                const splitAmount = (parseFloat(amountValue) / selected.length).toFixed(2)
                document.getElementById("confirmation").classList.remove("hidden")
                document.getElementById('requestConfirm').innerHTML = "Are you sure you'd like to request $" + amountValue + " split evenly ($" + splitAmount + " each) from " + selectedNames + " for " + noteValue + "?"
                updateSplitSummary()
            } else {
                alert("Please select at least one person to request from")
            }
        } else {
            alert("Please fill in ALL fields or check that you only inputted numbers in the money field")
        }
    })

    document.getElementById("requestConfirmYes").addEventListener('click', (event) => {
        event.preventDefault()
        const selected = getRequestPersonDivs().filter(div => div.classList.contains('selected'))
        selected.forEach(div => {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'requestPersonSelect[]'
            input.value = div.getAttribute('data-value')
            requestForm.appendChild(input)
        })
        requestConfirmed = true
        document.getElementById("confirmation").classList.add("hidden")
        requestForm.submit()
    })

    document.getElementById("requestConfirmNo").addEventListener('click', (event) => {
        event.preventDefault()
        requestConfirmed = false
        document.getElementById("confirmation").classList.add("hidden")
    })
}

//TRANSACTION HISTORY - div-based filter selection
const filterDivs = document.querySelectorAll('.filterDiv')
if (filterDivs.length > 0) {
    filterDivs.forEach(div => {
        div.addEventListener('click', () => {
            filterDivs.forEach(d => d.classList.remove('selected'))
            div.classList.add('selected')
            const hiddenInput = div.closest('form')?.querySelector('#hiddenTransactionType')
            if (hiddenInput) {
                hiddenInput.value = div.getAttribute('data-value')
            }
        })
    })
}

//signing up
const signupForm = document.getElementById("signupForm")
if (signupForm) {
    const passwordCreate = document.getElementById("passwordCreate")
    const passwordCreateCheck = document.getElementById("passwordCreateCheck")
    signupForm.addEventListener('submit', (event) => {
        if (passwordCreate.value == passwordCreateCheck.value) {
            document.getElementById("signupDoneButton").innerHTML = "create account"
        } else {
            alert("be sure your passwords match!")
            event.preventDefault()
        }
    })
}

    //entering family name
    const familySetupForm = document.getElementById("familySetup");
    const familyNameInput = document.getElementById("familyName")
    if (familySetupForm){
        familySetupForm.addEventListener('submit', (event) => {
            if (!familyNameInput.value) {
                alert("Please enter a family name!")
                event.preventDefault()
            }
        })
    }

//family edit page
if (document.getElementsByClassName('familyEditDOW')) {

    Array.from(document.getElementsByClassName('familyEditDOW')).forEach(selectEl => {
        selectEl.addEventListener('change', () => {
            selectEl.classList.add('familyEditChanged')
        })
    })

}

//transaction history page
if (document.getElementById('filterIcon')) {

    document.getElementById("filterIcon").addEventListener('click', (event) => {
        document.getElementById("filtersContainer").classList.toggle("hidden")
        document.getElementById("filterIcon").classList.toggle("open")
        document.getElementById("filterIcon").classList.toggle("closed")
    })
}

//index page 
if (document.getElementById('topMessage')) {
    setTimeout(() => {
        document.getElementById("topMessage").classList.add("topMessageHidden")
        document.getElementById("topMessage").classList.remove("topMessageShown")
    }, 3000);

    document.getElementById("topMessage").addEventListener('click', (event) => {
        document.getElementById("topMessage").classList.add("topMessageHidden")
        document.getElementById("topMessage").classList.remove("topMessageShown")
    })
}

//navbar
if (document.getElementById('topBar')) {
    window.onscroll = function () { scrollFunction('0') };

    menuButton = document.getElementById("menuButton");
    topBar = document.getElementById("topBar");
    title = document.getElementById("title");
    menu = document.getElementById("menu");
    exitIcon = document.getElementById("exitIcon");
    dimmedScreen = document.getElementById("dimmedScreen");

    topBar.addEventListener('click', (event) => {
        scrollFunction('1');
    })
    menuButton.addEventListener('click', (event) => {
        menu.style.left = "0px";
    })
    exitIcon.addEventListener('click', (event) => {
        menu.style.left = "-800px";
    })
}


function scrollFunction(click) {
    if (click == '1') {
        topBar.style.height = "150px";
        topBar.style.opacity = "1";
        title.style.fontSize = "110px";

        menuButton.style.width = "120px";
        menuButton.style.height = "120px";
        menuButton.style.transform = "rotate(0deg)";
        menuButton.style.opacity = "1";
    } else if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        topBar.style.height = "80px";
        topBar.style.opacity = "0.5";
        title.style.fontSize = "40px";

        menuButton.style.width = "80px";
        menuButton.style.height = "80px";
        menuButton.style.transform = "rotate(90deg)";
        menuButton.style.opacity = "0";
    } else {
        topBar.style.height = "150px";
        topBar.style.opacity = "1";
        title.style.fontSize = "110px";

        menuButton.style.width = "120px";
        menuButton.style.height = "120px";
        menuButton.style.transform = "rotate(0deg)";
        menuButton.style.opacity = "1";
    }
}

// promiseCards

const cards = document.getElementsByClassName('promiseCard')
Array.from(cards).forEach(card => {
    card.addEventListener('click', () => {
        card.classList.toggle('promiseCardFlipped')

        Array.from(card.getElementsByClassName('promiseCardText')).forEach(text => {
            setTimeout(() => {
                text.classList.toggle('hidden')
                Array.from(card.getElementsByClassName('promiseCardBack')).forEach(back => {
                    back.classList.toggle('hidden')
                })
                Array.from(card.getElementsByClassName('promiseCardBackground')).forEach(background => {
                    background.classList.toggle('hidden')
                })
            }, 150);
        })
    })
})
