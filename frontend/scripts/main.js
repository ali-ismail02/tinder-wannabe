const tinder = {};

tinder.baseURL = "http://127.0.0.1:8000/api";

tinder.Console = (title, values, oneValue = true) => {
    console.log('---' + title + '---');
    if(oneValue){
        console.log(values);
    }else{
        for(let i =0; i< values.length; i++){
            console.log(values[i]);
        }
    }
    console.log('--/' + title + '---');
}

tinder.getAPI = async (api_url) => {
    try{
        return await axios(api_url);
    }catch(error){
        tinder.Console("Error from GET API", error);
    }
}

tinder.postAPI = async (api_url, api_data, api_token = null) => {
    try{
        return await axios.post(
            api_url,
            api_data,
            { headers:{
                    'Authorization' : api_token
                }
            }
        );
    }catch(error){
        tinder.Console("Error from POST API", error);
    }
}