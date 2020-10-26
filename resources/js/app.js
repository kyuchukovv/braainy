require('./bootstrap');

function ready(callback) {
    // in case the document is already rendered
    if (document.readyState !== 'loading') callback();
    // modern browsers
    else if (document.addEventListener) document.addEventListener('DOMContentLoaded', callback);
    // IE <= 8
    else document.attachEvent('onreadystatechange', function () {
            if (document.readyState === 'complete') callback();
        });
}

ready(function () {
    // Product
    const customDatatable = document.getElementById('datatable-product');
    if (customDatatable) {
        document.getElementsByClassName('remove-product-button').forEach(btn => {
            btn.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this product?')) {
                    product.deleteProduct(btn.attributes['data-id'].value);
                }
            })
        });

        document.getElementsByClassName('edit-product-button').forEach(btn => {
            btn.addEventListener('click', () => {

            })
        })
    }

    var createProduct = document.getElementById("create_product");
    if (createProduct) {
        createProduct.addEventListener('click',
            function (event) {
                event.preventDefault();
                let data = {
                    name: document.getElementsByName('product_name')[0].value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                product.createProduct(data);
            });
    }
    var updateProduct = document.getElementById("edit-product-button");
    if (updateProduct) {
        updateProduct.addEventListener('click',
            function (event) {
                event.preventDefault();
                let id = document.getElementsByName('edit-product-id')[0].value;
                let data = {
                    name: document.getElementsByName('edit-product-name')[0].value,
                    description: document.getElementsByName('edit-product-description')[0].value,
                };
                product.updateProduct(id, data);
            });
    }
    var syncProductButton = document.getElementById("sync-products");
    if (syncProductButton) {
        syncProductButton.addEventListener('click', (event) => {
            event.preventDefault();

            product.syncProducts();
        });
    }
    /**
     *
     * @type {{updateProduct: updateProduct, createProduct: createProduct, deleteProduct: deleteProduct, syncProducts: syncProducts}}
     */
    var product = {
        /**
         *
         * @param data
         */
        createProduct: function (data) {
            window.axios.post('/product', data)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         * @param id
         * @param data
         */
        updateProduct: function (id, data) {
            window.axios.put(`/product/${id}`, data)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         * @param id
         */
        deleteProduct: function (id) {
            window.axios.delete(`/product/${id}`)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         */
        syncProducts: function () {
            window.axios.get('/product-sync')
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        }
    }


    const customContactDatatable = document.getElementById('datatable-contact');
    if (customContactDatatable) {
        document.getElementsByClassName('remove-contact-button').forEach(btn => {
            btn.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this contact?')) {
                    contact.deleteContact(btn.attributes['data-id'].value);
                }
            })
        });

        document.getElementsByClassName('edit-contact-button').forEach(btn => {
            btn.addEventListener('click', () => {

            })
        })
    }

    var createContact = document.getElementById("create_contact");
    if (createContact) {
        createContact.addEventListener('click',
            function (event) {
                event.preventDefault();
                let data = {
                    name: document.getElementsByName('contact_name')[0].value,
                    type: document.getElementsByName('contact_type')[0].value,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                contact.createContact(data);
            });
    }
    var updateContact = document.getElementById("edit-contact-button");
    if (updateContact) {
        updateContact.addEventListener('click',
            function (event) {
                event.preventDefault();
                let id = document.getElementsByName('edit-contact-id')[0].value;
                let data = {
                    name: document.getElementsByName('edit-contact-name')[0].value,
                    description: document.getElementsByName('edit-contact-description')[0].value,
                };
                contact.updateContact(id, data);
            });
    }
    var syncContactButton = document.getElementById("sync-contacts");
    if (syncContactButton) {
        syncContactButton.addEventListener('click', (event) => {
            event.preventDefault();

            contact.syncContacts();
        });
    }

    /**
     *
     * @type {{updateContact: updateContact, createContact: createContact, deleteContact: deleteContact, syncContacts: syncContacts}}
     */
    var contact = {
        /**
         *
         * @param data
         */
        createContact: function (data) {
            window.axios.post('/contact', data)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         * @param id
         * @param data
         */
        updateContact: function (id, data) {
            window.axios.put(`/contact/${id}`, data)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         * @param id
         */
        deleteContact: function (id) {
            window.axios.delete(`/contact/${id}`)
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        },
        /**
         *
         */
        syncContacts: function () {
            window.axios.get('/contact-sync')
                .then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                console.log(error);
            });
        }
    }
});
