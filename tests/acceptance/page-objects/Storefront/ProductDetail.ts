import type { Page, Locator } from '@playwright/test';
import type { PageObject } from '@fixtures/PageObject';

export class ProductDetailPage implements PageObject {
    public readonly addToCartButton: Locator;

    public readonly offCanvasCartTitle: Locator;
    public readonly offCanvasCart: Locator;
    public readonly offCanvasCartGoToCheckoutButton: Locator;

    private readonly product;

    constructor(public readonly page: Page, product) {
        this.addToCartButton = page.getByRole('button', { name: 'Add to shopping cart' });
        this.offCanvasCartTitle = page.getByText('Shopping cart');
        this.offCanvasCart = page.getByRole('dialog');
        this.offCanvasCartGoToCheckoutButton = page.getByRole('link', { name: 'Go to checkout' });

        this.product = product;
    }

    async goTo() {
        const url = `${this.product.translated.name.replaceAll('_', '-')}/${this.product.productNumber}`;

        await this.page.goto(url);
    }
}
