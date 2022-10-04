
// handling sign in form ---------------------------------------------
const forms = document.querySelectorAll(".form")
const email_login = document.getElementById("email-login")
const password_login = document.getElementById("password-login")
const wrong_cred = document.getElementById("wrong-cred")
const links = document.querySelectorAll(".switch-form")
const login = document.getElementById("login")

login.addEventListener("click", async () => {
    const data = {
        "email":email_login.value,
        "password":password_login.value
    }
    try {
        let response = await tinder.postAPI(tinder.baseURL + "/auth/login", data)
        localStorage.setItem("jwt", response.data.token_type + " " + response.data.access_token)
        console.log(localStorage.getItem('jwt'))
    }catch{
        email_login.style.border = "1px red solid"
        password_login.style.border = "1px red solid"
        wrong_cred.style.display="block"
    }
})

links.forEach(element => {
    element.addEventListener('click', () => {
    forms[0].classList.toggle('display-none')
    forms[1].classList.toggle('display-none')
})
});

// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")
// const email_login = document.getElementById("email-login")