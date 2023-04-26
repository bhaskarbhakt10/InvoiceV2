async function logJSONData() {
    const response = await fetch("https://countriesnow.space/api/v0.1/countries/flag/images");
    const jsonData = await response.json();
    console.log(jsonData);
}
logJSONData();