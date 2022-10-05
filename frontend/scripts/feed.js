const cards = document.getElementById("cards")
let response

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
    name.innerHTML = `${data['name']} ${getAge(data['dob'])}`
    card.appendChild(name)

    const bio = document.createElement('p')
    bio.classList.add('bio')
    bio.innerHTML = data['bio']
    card.appendChild(bio)
}

const onLoad = async () => {
    response = await tinder.postAPI(tinder.baseURL + "/users", null,localStorage.getItem('jwt'))
    for(const data of response.data.message){
        construct(data)
    }
} 
onLoad()