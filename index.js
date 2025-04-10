const index = Vue.createApp({
    data() {
        return {
            favActive: false,
            favItems: [],
            logActive: false,
            loggedIn: false,
            regActive: false,
            cartActive: false,
            cartItems: [],
            selectedCategory: null,
            menuItems: [
                { name: 'Turkey Tango Toast', price: 25, image: 'pas/pas01', category: 'pastry' },
                { name: 'Monkey Munch', price: 25, image: 'pas/pas02', category: 'pastry' },
                { name: 'Cloud Nine Crunch', price: 25, image: 'pas/pas03', category: 'pastry' },

                { name: 'Nordic Nirvana', price: 75, image: 'ent/ent05', category: 'entree' },
                { name: 'Powerhouse Scramble', price: 50, image: 'ent/ent03', category: 'entree' },
                { name: 'Coffee Clutch', price: 90, image: 'pas/pas14', category: 'pastry' },

                { name: 'Cattitude Country', price: 25, image: 'pas/pas06', category: 'pastry' },
                { name: 'Asian Adventure', price: 80, image: 'ent/ent08', category: 'entree' },
                { name: 'Rainbow Rhapsody', price: 60, image: 'ent/ent01', category: 'entree' },

                { name: 'Sticky Symphony', price: 45, image: 'des/des09', category: 'dessert' },
                { name: 'Garden Glory', price: 50, image: 'ent/ent02', category: 'entree' },
                { name: 'Zesty Zoodle Fiesta', price: 35, image: 'ent/ent15', category: 'entree' },

                { name: 'Summer Wonderland', price: 80, image: 'ent/ent09', category: 'entree' },
                { name: 'Sushi Sunset Surprise', price: 80, image: 'ent/ent10', category: 'entree' },
                { name: 'Whiskered Wonders', price: 30, image: 'pas/pas08', category: 'pastry' },

                { name: 'Neko Anpan', price: 25, image: 'pas/pas04', category: 'pastry' },
                { name: 'Hopscotch Cookies', price: 60, image: 'pas/pas15', category: 'pastry' },
                { name: 'Toasted Temptation', price: 50, image: 'des/des03', category: 'dessert' },

                { name: 'Hidden Veggie Hero', price: 60, image: 'ent/ent12', category: 'entree' },
                { name: 'California Dreaming', price: 40, image: 'ent/ent06', category: 'entree' },
                { name: 'Kneaded Bread', price: 25, image: 'pas/pas09', category: 'pastry' },

                { name: 'Green Goodness', price: 40, image: 'pas/pas11', category: 'pastry' },
                { name: 'Smiling Breakfast', price: 80, image: 'pas/pas12', category: 'pastry' },
                { name: 'Hootenanny Hocakes', price: 60, image: 'pas/pas13', category: 'pastry' },

                { name: 'Creamy Cheerio', price: 30, image: 'des/des05', category: 'dessert' },
                { name: 'Sunny Breakup', price: 35, image: 'ent/ent07', category: 'entree' },
                { name: 'Garden Harvest', price: 50, image: 'ent/ent04', category: 'entree' },

                { name: 'Colorful Crunch', price: 40, image: 'ent/ent14', category: 'entree' },
                { name: 'Dore Dore', price: 725, image: 'pas/pas10', category: 'pastry' },
                { name: 'Oatmeal Monster', price: 30, image: 'des/des06', category: 'dessert' },

                { name: 'Blueberry Bonanza', price: 40, image: 'des/des04', category: 'dessert' },
                { name: 'Sunrise Surprise', price: 25, image: 'des/des01', category: 'dessert' },
                { name: 'Cottage Crunch', price: 40, image: 'ent/ent11', category: 'entree' },

                { name: 'Gooey Oatmeal', price: 25, image: 'des/des07', category: 'dessert' },
                { name: 'Mediterranean Meal', price: 80, image: 'ent/ent13', category: 'entree' },
                { name: 'Meowmalade Dream', price: 75, image: 'pas/pas07', category: 'pastry' },

                { name: 'Mitten Bread', price: 25, image: 'pas/pas05', category: 'pastry' },
                { name: 'Something Different', price: 30, image: 'des/des02', category: 'dessert' },
                { name: 'Monkey Business', price: 40, image: 'des/des08', category: 'dessert' },
            ],
            checkoutActive: false,
            paymentFormActive: false,
            paymentMethod: '',
            paymentDetails: {
                cardholderName: '',
                cardNumber: '',
                expiryDate: '',
                cvv: ''
            },
            map: null,
            marker: null,
            location: ''
        };
    },
    methods: {
        fav() {
            if (!this.checkoutActive) {
                this.favActive = !this.favActive;
                this.cartActive = this.logActive = this.regActive = false;
            }
        },
        addToFav(item) {
            const existingItemIndex = this.favItems.findIndex(favItem => favItem.name === item.name);
            if (existingItemIndex === -1) {
                this.favItems.push({ ...item, quantity: 1 });
            }
        },
        removeFavItem(index) {
            this.favItems.splice(index, 1);
        },
        addToCartFromFav(item, index) {
            const existingCartItemIndex = this.cartItems.findIndex(cartItem => cartItem.name === item.name);
            if (existingCartItemIndex !== -1) {
                this.cartItems[existingCartItemIndex].quantity++;
            } else {
                this.cartItems.push({ ...item, quantity: 1 });
            }
            this.favItems.splice(index, 1);
        },
        log() {
            if (!this.checkoutActive) {
                this.logActive = !this.logActive;
                this.favActive = this.cartActive = this.regActive = false;
            }
        },
        reg() {
            if (!this.checkoutActive) {
                this.regActive = !this.regActive;
                this.favActive = this.cartActive = this.logActive = false;
            }
        },
        cart(event) {
            if (!this.checkoutActive) {
                this.cartActive = !this.cartActive;
                this.favActive = this.logActive = this.regActive = false;
                event.stopPropagation();
            }
        },
        addToCart(item) {
            const existingItemIndex = this.cartItems.findIndex(cartItem => cartItem.name === item.name);
            if (existingItemIndex !== -1) {
                this.cartItems[existingItemIndex].quantity++;
            } else {
                this.cartItems.push({ ...item, quantity: 1 });
            }
        },
        removeCartItem(index) {
            this.cartItems.splice(index, 1);
        },
        decreCartItem(index) {
            this.cartItems[index].quantity--;
            this.cartItems[index].quantity <= 0 && this.cartItems.splice(index, 1);
        },
        increCartItem(index) {
            this.cartItems[index].quantity++;
        },
        checkout() {
            if (this.cartItems.length > 0) {
                this.checkoutActive = true;
                this.searchActive = this.favActive = this.logActive = this.regActive = this.cartActive = false;
            }
        },
        closeCheckout() {
            this.checkoutActive = false;
        },
        closeCheckoutPopup() {
            this.checkoutActive = false;
        },
        closePaymentForm() {
            this.paymentFormActive = false;
        },
        closePaymentFormPopup() {
            this.paymentFormActive = false;
        },
        removeCartItemFromCheckout(index) {
            this.cartItems.splice(index, 1);
        },
        decreCartItemFromCheckout(index) {
            this.cartItems[index].quantity--;
            if (this.cartItems[index].quantity <= 0 && this.cartItems.length === 1) {
                this.cartItems.splice(index, 1);
                this.closeCheckoutPopup();
            } else if (this.cartItems[index].quantity <= 0) {
                this.cartItems.splice(index, 1);
            }
        },
        increCartItemFromCheckout(index) {
            this.cartItems[index].quantity++;
        },
        checkLogin() {
            $.ajax({
                type: "GET",
                url: "frontend/checklogin.php",
                success: (response) => {
                    if (response !== 'not_logged_in') {
                        this.loggedIn = true;
                    } else {
                        this.loggedIn = false;
                    }
                }
            });
        },
        logout(event) {
            event.stopPropagation();
            $.ajax({
                type: "POST",
                url: "frontend/user_information.php",
                data: { logout: true },
                success: () => {
                    this.loggedIn = false;
                    window.location.href = "index.php";
                }
            });
        },
        openPaymentForm() {
            this.checkoutActive = false;
            this.paymentFormActive = true;
            this.initMap();
        },
        processPaymentAndAddress() {
            navigator.geolocation.getCurrentPosition((position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                $.ajax({
                    type: "POST",
                    url: "backend/save_location.php",
                    data: { latitude: latitude, longitude: longitude },
                    success: (response) => {
                        console.log(response);
                    },
                    error: (error) => {
                        console.error(error);
                    }
                });
                const paymentDetails = this.paymentDetails;
                $.ajax({
                    type: "POST",
                    url: "backend/save_payment.php",
                    data: {
                        cardholderName: paymentDetails.cardholderName,
                        cardNumber: paymentDetails.cardNumber,
                        expiryDate: paymentDetails.expiryDate,
                        cvv: paymentDetails.cvv,
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: (response) => {
                        console.log(response);
                        if (response.includes("successful")) {
                            alert("Order Successful");
                            this.cartItems = [];
                            localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                            window.location.href = "frontend/user_information.php?track=true";
                        } else {
                            alert("Order Unsuccessful. Please Try Again.");
                        }
                    },
                    error: (error) => {
                        console.error(error);
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "backend/save_checkout.php",
                    data: { cartItems: JSON.stringify(this.cartItems) },
                    success: (response) => {
                        console.log(response);
                    },
                    error: (error) => {
                        console.error(error);
                    }
                });
                console.log('Processing payment...');
            });
        },
        backToCheckout() {
            this.paymentFormActive = false;
            this.checkoutActive = true;
        },
        isMastercard(cardNumber) {
            const mastercardRegex = /^(5[1-5][0-9]{14})$/;
            return mastercardRegex.test(cardNumber);
        },
        isVisa(cardNumber) {
            const visaRegex = /^(4[0-9]{12}(?:[0-9]{3})?)$/;
            return visaRegex.test(cardNumber);
        },
        autoFormatExpiryDate() {
            this.paymentDetails.expiryDate = this.paymentDetails.expiryDate.replace(/\D/g, '');
            if (this.paymentDetails.expiryDate.length > 4) {
                this.paymentDetails.expiryDate = this.paymentDetails.expiryDate.slice(0, 4);
            }
            if (this.paymentDetails.expiryDate.length > 2) {
                this.paymentDetails.expiryDate = this.paymentDetails.expiryDate.slice(0, 2) + '/' + this.paymentDetails.expiryDate.slice(2);
            }
        },
        autoFormatCVV() {
            this.paymentDetails.cvv = this.paymentDetails.cvv.replace(/\D/g, '').slice(0, 3);
        },
        loadCartItemsFromLocalStorage() {
            const cartItems = localStorage.getItem('cartItems');
            if (cartItems) {
                this.cartItems = JSON.parse(cartItems);
            }
        },
        saveFavItemsToLocalStorage() {
            localStorage.setItem('favItems', JSON.stringify(this.favItems));
        },
        loadFavItemsFromLocalStorage() {
            const favItems = localStorage.getItem('favItems');
            if (favItems) {
                this.favItems = JSON.parse(favItems);
            }
        },
        selectCategory(category) {
            this.selectedCategory = category;
        }
    },
    computed: {
        getTotalPrice() {
            return this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
        },
        totalItemCount() {
            return this.cartItems.reduce((total, item) => total + item.quantity, 0);
        },
        expiryDate: {
            get() {
                return this.paymentDetails.expiryDate;
            },
            set(value) {
                this.paymentDetails.expiryDate = value;
            }
        },
        filteredMenuItems() {
            if (!this.selectedCategory) {
                return this.menuItems;
            }
            return this.menuItems.filter(item => item.category === this.selectedCategory);
        }
    },
    mounted() {
        this.loadCartItemsFromLocalStorage();
        this.loadFavItemsFromLocalStorage();
        this.checkLogin();
    },
    watch: {
        cartItems: {
            handler(newItems) {
                localStorage.setItem('cartItems', JSON.stringify(newItems));
            },
            deep: true
        },
        favItems: {
            handler(newItems) {
                localStorage.setItem('favItems', JSON.stringify(newItems));
            },
            deep: true
        }
    }
});
index.mount('#index');