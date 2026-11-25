import { Locator, Page, expect } from "@playwright/test";
import { CommonPage } from "../../utils/tinymce";
import { WebAllLocators } from "../../pageObjects/locator";

export class adminCreateProduct {
    readonly page: Page;
    readonly locators: WebAllLocators;

    constructor(page: Page) {
        this.page = page;
        this.locators = new WebAllLocators(page);
    }

    // Navigate to the admin Product section
    async adminProductPageGoto() {
        await this.page.goto(`${process.env.APP_ADMIN_URL || "admin"}/catalog/products`);
    }

    async adminCreateproduct(
        sku: string,
        productname: string,
        shortDescription: string,
        price: String,
        weight: Number,
        inventory: Number
    ) {
        const commonPage = new CommonPage(this.locators.page);
        await this.locators.adminProductCreateButton.click();
        await this.page.waitForTimeout(2000);
        await this.locators.selectProductType.selectOption("simple");
        await this.locators.selectAttribute.selectOption("1");
        await this.locators.productSku.fill(sku);
        await this.locators.adminClickSaveProductButton.click();
        await this.page.waitForURL(new RegExp(`/${process.env.APP_ADMIN_URL || "admin"}/catalog/products/edit/\\d+`), {
            timeout: 30000,
        });
        await expect(this.locators.productName).toBeVisible({ timeout: 30000 });

        await this.locators.productName.fill(productname);
        await commonPage.fillInTinymce(
            this.locators.productShortDescription,
            shortDescription
        );
        await commonPage.fillInTinymce(
            this.locators.productDescription,
            shortDescription
        );
        await this.locators.productPrice.fill(price.toString());
        await this.locators.productWeight.fill(weight.toString());
        await this.locators.adminProductInventory.fill(inventory.toString());

        await this.locators.clickSaveProduct.click();
        await this.page.waitForTimeout(1000);

        await expect(this.locators.updateProductSuccessToast).toBeVisible();
    }
}
