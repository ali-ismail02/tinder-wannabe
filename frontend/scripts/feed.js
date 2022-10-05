const cards = document.getElementById("cards")
const profile_page = document.querySelector(".profile-view-main")
const profile_name = document.querySelector(".profile-view-name")
const profile_bio = document.querySelectorAll(".profile-view-bio")
const profile_image = document.querySelector(".profile-view-image")
const close_button = document.getElementById('close')
let response

//functions

const getAge = (dateString) => {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
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
    })
}

const onLoad = async () => {
    response = await tinder.postAPI(tinder.baseURL + "/users", null, localStorage.getItem('jwt'))
    for (const data of response.data.message) {
        construct(data)
    }
}

// adding eventlistners

close_button.addEventListener('click', () => {
    profile_page.style.display = "none"
})

onLoad()