import { test as base } from '@playwright/test';
import { expect } from '@fixtures/AcceptanceTest';

export const CartWithProductData = base.extend({
    cartWithProductData: async ({ storeApiContext, defaultStorefront, salesChannelProduct }, use) => {
        // Login customer in store API context.
        await storeApiContext.login(defaultStorefront.customer);

        // Create new cart for the shop customer.
        const cartResponse = await storeApiContext.post(`checkout/cart`, {
            data: {
                name: `default-customer-cart`,
            },
        });
        expect(cartResponse.ok()).toBeTruthy();

        // Create new line items in the cart.
        const lineItemResponse = await storeApiContext.post('checkout/cart/line-item', {
            data: {
                items: [
                    {
                        type: 'product',
                        referencedId: salesChannelProduct.id,
                        quantity: 10,
                    },
                ],
            },
        });
        expect(lineItemResponse.ok()).toBeTruthy();

        const cartData = await lineItemResponse.json();

        use(cartData);
    },
});
