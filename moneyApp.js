//sending
const sendDoneButton = document.getElementById("sendDoneButton")
if (sendDoneButton) {
    sendForm.addEventListener('submit', (event) => {
        if (!event.submitter.dataset["submit"]){
            event.preventDefault()
        }

        if (document.getElementById('sendCashAmount').value && document.getElementById('sendNote').value) {
            var personSelect = document.getElementById( "sendPersonSelect" )
            if(personSelect.options[ personSelect.selectedIndex ].value != "?null"){ 
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
        if (!event.submitter.dataset["submit"]){
            event.preventDefault()
        }

        if (document.getElementById('requestCashAmount').value && document.getElementById('requestNote').value) {
            var personSelect = document.getElementById( "requestPersonSelect" )
            if(personSelect.options[ personSelect.selectedIndex ].value != "?null"){
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
if(document.getElementsByClassName('familyEditDOW')){
    
    Array.from(document.getElementsByClassName('familyEditDOW')).forEach(selectEl =>{
        selectEl.addEventListener('change',() => {
            selectEl.classList.add('familyEditChanged')
        })
    })

}
