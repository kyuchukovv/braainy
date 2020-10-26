require('./bootstrap');

function ready(callback) {
    // in case the document is already rendered
    if (document.readyState != 'loading') callback();
    // modern browsers
    else if (document.addEventListener) document.addEventListener('DOMContentLoaded', callback);
    // IE <= 8
    else document.attachEvent('onreadystatechange', function () {
            if (document.readyState == 'complete') callback();
        });
}

ready(function () {

    var createProduct = document
        .getElementById("create_product")
        .addEventListener('click',
            function (event) {
                event.preventDefault();
                let data = {
                    name: document.getElementsByName('product_name')[0].value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                product.createProduct(data);
            });
    var product = {
        createProduct: function (data) {
            window.axios.post('/product', data)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            })
        }
    }
});
