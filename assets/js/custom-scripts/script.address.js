async function getCountriesAndFlags() {
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/flag/images");
    const jsonData = await response.json();
    if (jsonData.error === false) {
        return jsonData.data;
    }
    else {
        return false;
    }
}
async function getState(selected_county) {
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/states/q?country="+selected_county);
    const jsonData = await response.json();
    if (jsonData.error === false) {
        return jsonData.data;
    }
    else {
        return false;
    }
}


if (document.querySelector('#address-country') !== null) {
    let address_country = document.querySelector('#address-country');
    let address_country_options = address_country.querySelector('option');
    let address_country_state = document.querySelector('#address-country-state')


    let countries_and_flags = getCountriesAndFlags();
    async function countries() {
        if (countries_and_flags !== false) {
            let options = "";
            countries_and_flags.then(function (result) {
                for (const key in result) {
                    const element = result[key];
                    let country_name = element.name;
                    options += "<option value=" + country_name + ">" + country_name + "</option>";
                }
                address_country.innerHTML = options;
            })
        }
    }

    async function renderSatates(selected_county){
        let states = getState(selected_county);
        if(states !== false){
            let state = '';
            states.then(function(result_states){
                let states_obj = result_states.states;
               for (const key in states_obj) {
                    const element = states_obj[key];
                    let state_name = element.name;
                    state += "<option value=" + state_name + ">" + state_name + "</option>";
               }
               address_country_state.innerHTML = state;
            })

        } 
    }

    address_country.addEventListener('focus', (e) => {
        e.preventDefault();
        countries();
    });
    address_country.addEventListener('change', (e) => {
        e.preventDefault();
        let selected_county = e.target.value;
        renderSatates(selected_county);
    });
}