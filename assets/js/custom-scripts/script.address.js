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
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/states/q?country=" + selected_county);
    const jsonData = await response.json();
    if (jsonData.error === false) {
        return jsonData.data;
    }
    else {
        return false;
    }
}

async function getCities(selected_state, selected_country) {
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/state/cities/q?country=" + selected_country + "&state=" + selected_state);
    const jsonData = await response.json();
    if (jsonData.error === false) {
        return jsonData.data;
    }
    else {
        return false;
    }
}

async function getDialCodes(selected_country) {
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/codes/q?country=" + selected_country);
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
    let address_country_city = document.querySelector('#address-country-city')
    let address_country_code = document.querySelector('#address-country-code')


    let countries_and_flags = getCountriesAndFlags();
    async function countries() {
        if (countries_and_flags !== false) {
            let options = "";
            countries_and_flags.then(function (result) {
                for (const key in result) {
                    const element = result[key];
                    let country_name = element.name;
                    options += "<option value='" + country_name + "'>" + country_name + "</option>";
                }
                address_country.innerHTML = options;
            })
        }
    }

    async function renderSatates(selected_county) {
        let states = getState(selected_county);
        if (states !== false) {
            let state = '';
            states.then(function (result_states) {
                let states_obj = result_states.states;
                for (const key in states_obj) {
                    const element = states_obj[key];
                    let state_name = element.name;
                    state += "<option value='" + state_name + "'>" + state_name + "</option>";
                }
                address_country_state.innerHTML = state;
            })

        }
    }
    async function renderCities(selected_state, selected_country) {
        let cities = getCities(selected_state, selected_country);
        if(cities !== false) {
            let city = '';
            cities.then(function (result_cities) {
                let cities_obj = result_cities;
                // console.warn(cities_obj)
                for (const key in cities_obj) {
                    const element = cities_obj[key];
                    // console.log(element);
                    let city_name = element;
                    city += "<option value='" + city_name + "'>" + city_name + "</option>";
                }
                address_country_city.innerHTML = city;
            })

        }
    }

    async function dialCodes(selected_county){
        let dialcode = getDialCodes(selected_county);
        if(dialcode !== false) {
            dialcode.then(function (result_dialcode) {
                let dialcode_obj = result_dialcode;
                console.log(dialcode_obj.dial_code)
                address_country_code.value = dialcode_obj.dial_code;
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
        dialCodes(selected_county);
    });
    address_country_state.addEventListener('change', (e) => {
        e.preventDefault();
        let selected_country = address_country.value;
        let selected_state = e.target.value;
        console.log(selected_state, selected_country);
        renderCities(selected_state, selected_country);
    });
}
