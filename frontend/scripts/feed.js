const search_input = document.getElementById("search-input")
const cards = document.getElementById("cards")
const profile_page = document.querySelector(".profile-view-main")
const profile_name = document.querySelector(".profile-view-name")
const profile_bio = document.querySelectorAll(".profile-view-bio")
const profile_image = document.querySelector(".profile-view-image")
const fav = document.getElementById('fav')
const chat = document.getElementById('chat')
const close_button = document.getElementById('close')
let profile_id = 0
let profiles = new Array()
let response

//functions

const getAge = (dateString) => {
    let today = new Date()
    let birthDate = new Date(dateString)
    let age = today.getFullYear() - birthDate.getFullYear()
    let m = today.getMonth() - birthDate.getMonth()
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--
    }
    return age
}

//check if user is already favorited to change favorite button text
const favorited = async (profile_id) => {
    const data = {
        "id": profile_id
    }
    let response = await tinder.postAPI(tinder.baseURL + "/check-favorite", data, localStorage.getItem('jwt'))
    if(response.data.status) fav.innerHTML = "Favorited"
}

const construct = (data) => {
    const card = document.createElement('div')
    card.classList.add("card")
    cards.appendChild(card)

    const image = document.createElement('img')
    image.src = `../../${data['image']}`
    card.appendChild(image)

    const name = document.createElement('p')
    name.classList.add('name')
    name.innerHTML = `${data['name']} - ${getAge(data['dob'])}`
    card.appendChild(name)

    const bio = document.createElement('p')
    bio.classList.add('bio')
    bio.innerHTML = data['bio']
    card.appendChild(bio)

    card.addEventListener("click", () => {
        profile_name.innerHTML = data['name']
        profile_bio[0].innerHTML = `<span>Age: </span>${getAge(data['dob'])}`
        profile_bio[1].innerHTML = `<span>Gender: </span>${data['gender']}`
        profile_bio[2].innerHTML = `<span>Preference: </span>${data['pref']}`
        profile_bio[3].innerHTML = `<span>Address: </span>${data['location']}`
        profile_bio[4].innerHTML = `<span>Bio: </span><br>${data['bio']}`
        profile_image.style.backgroundImage = `url(../../${data['image']})`
        profile_image.classList.add('bg')
        profile_page.style.display = "flex"
        profile_id = data['id']
        favorited(profile_id)
    })
    profiles.push(card)
}

const onLoad = async () => {
    let response = await tinder.postAPI(tinder.baseURL + "/users", null, localStorage.getItem('jwt'))
    for (const data of response.data.message) {
        construct(data)
    }
}

const searchApi = async () => {
    for(const card of profiles){
        cards.removeChild(card)
    }
    profiles = []
    const data = {
        "search": search_input.value
    }
    let response = await tinder.postAPI(tinder.baseURL + "/search", data, localStorage.getItem('jwt'))

    for (const data of response.data.message) {
        construct(data)
    }
}

// adding eventlistners

close_button.addEventListener('click', () => {
    profile_page.style.display = "none"
})

search_input.addEventListener('change', () => {
    searchApi()
})


// toggle favorite of user
fav.addEventListener('click', async () => {
    const data = {
        "id": profile_id
    }
    let response = await tinder.postAPI(tinder.baseURL + "/favorite", data, localStorage.getItem('jwt'))
    if(response.data.status){
        fav.innerHTML = "Favorited"
        return
    } 
    fav.innerHTML = "Favorite"
})

onLoad()