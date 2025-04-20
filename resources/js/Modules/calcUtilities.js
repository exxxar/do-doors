import cartModule from '../Store/modules/cart.js';
import dictionaryModule from '../Store/modules/dictionaries.js';
import store from '../Store'

export function useCalcUtilities() {
    const cart = cartModule;
    const dict = dictionaryModule;


    function recountPrices(priceType, dealerPercent = 0) {

        /// console.log( "looog",store.state.items)

        let items = cart.state.items
        const dictionary = dict.state.dictionary

        let sum = 0;

        let base = null

        let tmp_prices = [];

        let type = priceType.key


        let intRound = (arg) => {
            return Math.round(parseInt(arg) / 10) * 10;
        }


        items.forEach(productItem => {

            const doorForm = productItem.product

            let doorTypeFunc = (tmpBasePrice) => {
                let tmpDoorTypePrice = typeof doorForm["door_type"].price === "object" ?
                    doorForm["door_type"].price[type] :
                    doorForm["door_type"].price

                let koef = doorForm["door_type"].id !== 3 ? 1 : 0.8
                let price = doorForm["door_type"].need_percent_price ?
                    (tmpBasePrice * tmpDoorTypePrice) / 100 : (tmpBasePrice * koef + tmpDoorTypePrice)

                tmp_prices.push({
                    type: "door_type",
                    price: (price || 0) > 0 ? price : tmpBasePrice
                })

                return (price || 0) > 0 ? price : tmpBasePrice
            }


            Object.keys(doorForm).forEach(item => {


                let find = false
                if (item) {

                    if (typeof doorForm[item] === "object"
                        && doorForm[item] != null
                        && item !== "door_type"
                    ) {
                        if (item === "opening_type" && doorForm[item].sizes) {
                            find = true
                            let index = doorForm[item].sizes.findIndex(c =>
                                c.width == doorForm.width &&
                                c.height == doorForm.height)

                            let price = index === -1 ? 0 : doorForm[item].sizes[index].price[type]
                            sum += parseInt(price || 0)

                            console.log("opening_type", price, item)
                            tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }

                        if (item.indexOf("_color") !== -1 && doorForm[item].sizes && !find) {
                            find = true

                            let isExcluded = (doorForm[item] || {excludes: []})
                                .excludes.indexOf(item
                                    .substring(0, item
                                        .indexOf("_color"))) !== -1

                            let price = 0;
                            if (!doorForm[item].assign_with_size)
                                price = isExcluded ? 0 : doorForm[item].sizes[0].price[type]
                            else {
                                let index = doorForm[item].sizes.findIndex(c =>
                                    c.width == doorForm.width &&
                                    c.height == doorForm.height)

                                price = index === -1 || isExcluded ? 0 : doorForm[item].sizes[index].price[type]
                            }

                            sum += parseInt(price || 0)

                            tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }

                        if (item === "hinge_manufacturer" && doorForm[item].title != null && !find) {
                            find = true

                            let price = doorForm[item].price[type]
                            let fullPrice = 0

                            if (doorForm.size)
                                fullPrice = doorForm.size.loops.count * price

                            sum += parseInt(fullPrice || 0)

                            tmp_prices.push({
                                type: item,
                                price: price,
                                full_price: fullPrice
                            })
                        }

                        if (item === "size" && doorForm[item].loops.price && !find) {
                            find = true
                            let price = doorForm[item].loops.price[type]
                            sum += parseInt(price || 0)


                            tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }


                        if (item === "service_painting" && doorForm[item].title != null && !find) {
                            find = true

                            let price = doorForm["fittings_color"].is_ral ? doorForm[item].price[type] : 0
                            let fullPrice = 0

                            if (doorForm.size)
                                fullPrice = (doorForm.size.loops.count + 1) * price

                            sum += fullPrice || 0

                            tmp_prices.push({
                                type: item,
                                price: price,
                                full_price: fullPrice
                            })
                        }


                        if (doorForm[item].price && !find) {

                            let price = (typeof doorForm[item].price === "object") ?
                                (doorForm[item].price[type] || 0) :
                                (doorForm[item].price || 0)

                            sum += parseInt(price || 0)

                            tmp_prices.push({
                                type: item,
                                price: price
                            })
                        }

                    }
                }

            })

            let basePrices = dictionary.prices

            let price = 0

            let find = false
            let section = null;
            basePrices.forEach(item => {

                if (item.width === doorForm.width && item.height === doorForm.height) {
                    find = true
                    section = item;
                }


            })


            if (find) {
                base = section.materials.find(m => m.is_base) || {
                    price: {
                        wholesale: 0,
                        dealer: 0,
                        retail: 0,
                        cost: 0,
                    }
                }

                let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                tmp_prices.push({
                    type: 'base',
                    price: tmpBasePrice
                })

                price = parseInt(doorTypeFunc(tmpBasePrice))

                //sum += parseInt(doorTypeFunc(tmpBasePrice))

                section.materials.forEach(sub => {
                    if (sub.id === doorForm.front_side_finish.id
                        && !doorForm.front_side_finish.is_base
                    ) {
                        let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                        price += tmpPrice

                        this.ces.push({
                            type: 'front_side_finish',
                            price: tmpPrice
                        })
                    }

                    if (sub.id === doorForm.back_side_finish.id
                        && !doorForm.back_side_finish.is_base
                    ) {
                        let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                        price += tmpPrice

                        tmp_prices.push({
                            type: 'back_side_finish',
                            price: tmpPrice
                        })
                    }

                })


            } else {

                for (let i = 0; i < basePrices.length; i++) {
                    if (basePrices[i].width >= doorForm.width && basePrices[i].height >= doorForm.height) {

                        base = basePrices[i].materials.find(m => m.is_base) || {
                            price: {
                                wholesale: 0,
                                dealer: 0,
                                retail: 0,
                                cost: 0,
                            }
                        }

                        let tmpBasePrice = typeof base.price === "object" ? base.price[type] : base.price

                        tmp_prices.push({
                            type: 'base',
                            price: tmpBasePrice
                        })


                        price = parseInt(doorTypeFunc(tmpBasePrice))


                        //  sum += parseInt(doorTypeFunc(tmpBasePrice))

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === doorForm.front_side_finish.id
                                && !doorForm.front_side_finish.is_base
                            ) {


                                let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                price += tmpPrice
                                tmp_prices.push({
                                    type: 'front_side_finish',
                                    price: tmpPrice
                                })
                            }

                        })

                        basePrices[i].materials.forEach(sub => {
                            if (sub.id === doorForm.back_side_finish.id
                                && !doorForm.back_side_finish.is_base
                            ) {

                                let tmpPrice = typeof sub.price === "object" ? sub.price[type] : sub.price
                                price += tmpPrice
                                tmp_prices.push({
                                    type: 'back_side_finish',
                                    price: tmpPrice
                                })
                            }

                        })
                        break;
                    }
                }
            }


            doorForm.price =  dealerPercent === 0 ? intRound(sum + price):
                Math.round((intRound(sum + price) || 0) * (1 + ((dealerPercent || 0) / 100)))

            doorForm.base_price = tmp_prices.find(item => item.type === 'door_type')?.price || 0

            console.log("price",  doorForm.price,  doorForm.base_price )
        })

        store.dispatch("updateCartItems", items)
        console.log(store.getters.cartTotalPrice)
    }


    return {
        recountPrices,
    };
}
