
// handling sign in form ---------------------------------------------
const inputs_login = new Array()
const forms = document.querySelectorAll(".form")
inputs_login.push(email_login = document.getElementById("email-login"))
inputs_login.push(password_login = document.getElementById("password-login"))
const wrong_cred = document.getElementById("wrong-cred")
const links = document.querySelectorAll(".switch-form")
const login = document.getElementById("login")

login.addEventListener("click", async () => {
    let flag = 1
    for (const input of inputs_login) {
        if (input.value == "") {
            flag = 0
            input.style.border = "red 1px solid"
        }
    }
    if (flag) {
        const data = {
            "email": inputs_login[0].value,
            "password": inputs_login[1].value
        }
        let response = await tinder.postAPI(tinder.baseURL + "/auth/login", data)
        if (response.data.status) {
            localStorage.setItem("jwt", response.data.token_type + " " + response.data.access_token)
            console.log(localStorage.getItem("jwt"))
        } else {
            email_login.style.border = "1px red solid"
            password_login.style.border = "1px red solid"
            wrong_cred.style.display = "block"
        }
    }
})

links.forEach(element => {
    element.addEventListener('click', () => {
        forms[0].classList.toggle('display-none')
        forms[1].classList.toggle('display-none')
    })
});

// handling sign up form ---------------------------------------------
const inputs = new Array()
inputs.push(email = document.getElementById("email"))
inputs.push(password = document.getElementById("password"))
const image = document.getElementById("image")
inputs.push(full_name = document.getElementById("name"))
inputs.push(dob = document.getElementById("dob"))
inputs.push(gender = document.getElementById("gender"))
inputs.push(pref = document.getElementById("pref"))
inputs.push(address = document.getElementById("address"))
inputs.push(bio = document.getElementById("bio"))
const signup = document.getElementById("signUp")
const dup_email = document.getElementById("email-taken")
const form_image = document.getElementById("form-img")
let image_binary = null
const reader = new FileReader()

signup.addEventListener("click", async () => {
    let flag = 1
    for (const input of inputs) {
        if (input.value == "") {
            flag = 0
            input.style.border = "red 1px solid"
        }
    }
    if (flag) {
        for (const input of inputs) {
            if (input.value == "") {
                flag = 0
                input.style.border = "black 1px solid"
            }
        }
        const data = {
            "email": inputs[0].value,
            "password": inputs[1].value,
            "image": image_binary,
            "name": inputs[2].value,
            "dob": inputs[3].value,
            "gender": inputs[4].value,
            "pref": inputs[5].value,
            "address": inputs[6].value,
            "bio": inputs[7].value
        }
        let response = await tinder.postAPI(tinder.baseURL + "/signUp", data)
        if (response.data.status == 1) {
            let login = await tinder.postAPI(tinder.baseURL + "/auth/login", data)
            localStorage.setItem("jwt", login.data.token_type + " " + login.data.access_token)
        } else {
            email.style.border = "1px red solid"
            dup_email.style.display = "block"
        }
    }
})

image.addEventListener("change", () => {
    reader.readAsDataURL(image.files[0]);
})

reader.addEventListener("load", () => {
    image_binary = reader.result
    form_image.style.backgroundImage = `url(${image_binary})`
    form_image.style.backgroundPosition = "center"
    form_image.style.backgroundSize = "cover"
    form_image.style.backgroundRepeat = "no-repeat"
    console.log(form_image.style.backgroundImage)
    console.log(image_binary)
})