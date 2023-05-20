function is_required(){
    let empty_requires_array = new Array();
    let all_required = $('[required]').toArray();
    for (let index = 0; index < all_required.length; index++) {
        if($(all_required[index]).val() !== ''){
            empty_requires_array.push(0);
        }
        else{
            $(all_required[index]).closest('label');
        }
        
    }
    console.log(empty_requires_array);
}