//sending
const sendDoneButton = document.getElementById("sendDoneButton")
if (sendDoneButton) {
    sendForm.addEventListener('submit', (event) => {
        if (!event.submitter.dataset["submit"]) {
            event.preventDefault()
        }

        if (document.getElementById('sendCashAmount').value && document.getElementById('sendNote').value) {
            var personSelect = document.getElementById("sendPersonSelect")
            if (personSelect.options[personSelect.selectedIndex].value != "?null") {
                document.getElementById("confirmation").classList.remove("hidden")
                document.getElementById('sendConfirm').innerHTML = "Are you sure you'd like to send $" + document.getElementById('sendCashAmount').value + " to " + document.getElementById("sendPersonSelect").options[document.getElementById("sendPersonSelect").selectedIndex].text + " for " + document.getElementById('sendNote').value + "?"
            } else {
                event.preventDefault()
                alert("Please select who you'd like to send to")
            }
        } else {
            event.preventDefault()
            alert("Please fill in ALL fields or check that you only inputted numbers in the money field")
        }
    })
    document.getElementById("sendConfirmYes").addEventListener('click', (event) => {
        document.getElementById('sendCashAmount').value
    })
    document.getElementById("sendConfirmNo").addEventListener('click', (event) => {
        document.getElementById("confirmation").classList.add("hidden")
        event.preventDefault()
    })
}

//requesting
const requestDoneButton = document.getElementById("requestDoneButton")
if (requestDoneButton) {
    requestForm.addEventListener('submit', (event) => {
        if (!event.submitter.dataset["submit"]) {
            event.preventDefault()
        }

        if (document.getElementById('requestCashAmount').value && document.getElementById('requestNote').value) {
            var personSelect = document.getElementById("requestPersonSelect")
            if (personSelect.options[personSelect.selectedIndex].value != "?null") {
                document.getElementById("confirmation").classList.remove("hidden")
                document.getElementById('requestConfirm').innerHTML = "Are you sure you'd like to request $" + document.getElementById('requestCashAmount').value + " from " + document.getElementById("requestPersonSelect").options[document.getElementById("requestPersonSelect").selectedIndex].text + " for " + document.getElementById('requestNote').value + "?"
            } else {
                event.preventDefault()
                alert("Please fill the person select field")
            }
        } else {
            event.preventDefault()
            alert("Please fill in ALL fields or check that you only inputted numbers in the money field")
        }
    })
    document.getElementById("requestConfirmYes").addEventListener('click', (event) => {
        document.getElementById('requestCashAmount').value
    })
    document.getElementById("requestConfirmNo").addEventListener('click', (event) => {
        document.getElementById("confirmation").classList.add("hidden")
        event.preventDefault()
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
