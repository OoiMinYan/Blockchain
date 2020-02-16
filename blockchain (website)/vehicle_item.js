// update vehicle model
function updateVehicleModel() {
    var brand_ele = document.getElementById("vbrand");
    var brand = brand_ele.options[brand_ele.selectedIndex].value;
    var url = "./vehicle_item.php?action=getModel&brand=" + brand;

    /*clear all option in the list*/
    $('#vmodel').empty();

    $.getJSON(url, function(data) {
        $.each(data, function(key, val) {
            var val = JSON.stringify(val);
            var obj = jQuery.parseJSON(val);

            $('#vmodel').append('<option value="' + obj.vmodel + '">' + obj.vmodel + '</option>');
        });

        // trigger change on vmodel to execute updateVehicleColour().
        $('#vmodel').change();

        // update vehicle price
        getVehiclePrice();
    })
}

// update vehicle colour
function updateVehicleColour() {
    console.log("color");
    var model_ele = document.getElementById("vmodel");
    var model = model_ele.options[model_ele.selectedIndex].value;
    var url = "./vehicle_item.php?action=getColour&model=" + model;

    /*clear all option in the list*/
    $('#vcolour').empty();

    $.getJSON(url, function(data) {
        $.each(data, function(key, val) {
            var val = JSON.stringify(val);
            var obj = jQuery.parseJSON(val);

            $('#vcolour').append('<option value="' + obj.vcolour + '">' + obj.vcolour + '</option>');
        });
    })

    // update vehicle price
    getVehiclePrice();
}

// get vehicle price
function getVehiclePrice() {
    console.log("price");
    var model_ele = document.getElementById("vmodel");
    var model = model_ele.options[model_ele.selectedIndex].value;
    var url = "./vehicle_item.php?action=getPrice&model=" + model;

    console.log(url);

    /*clear all option in the list*/
    $('#vprice').empty();

    $.getJSON(url, function(data) {
        $.each(data, function(key, val) {
            var val = JSON.stringify(val);
            var obj = jQuery.parseJSON(val);

            $('#vprice').val(obj.vprice);
        });
    })
}